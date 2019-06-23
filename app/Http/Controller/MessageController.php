<?php declare(strict_types=1);

namespace App\Http\Controller;

use const E_USER_ERROR;
use ReflectionException;
use RuntimeException;
use Swoft;
use Swoft\Bean\Exception\ContainerException;
use Swoft\Context\Context;
use Swoft\Http\Message\ContentType;
use Swoft\Http\Message\Response;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\View\Renderer;
use Throwable;
use function trigger_error;
use Swoft\Http\Message\Server\Request;
use Swoft\Db\DB;
use App\Model\Entity\User;
use App\Model\Entity\Message;
use Swoft\Redis\Exception\RedisException;
use Swoft\Redis\Redis;

/**
 * Class MessageController
 * @Controller()
 */
class MessageController
{
    private $client_id;
    private $client_secret;
    private $client_callback;

    public function __construct()
    {
        $this->client_id=env('github_client_id');
        $this->client_secret=env('github_client_secret');
        $this->client_callback=env('github_client_callback');
    }

    /**
     * @RequestMapping("/message[/{page}]")
     * @param int $page
     * @return Response
     * @throws ReflectionException
     * @throws ContainerException
     */
    public function index(int $page): Response
    {
        $request = \Swoft\Context\Context::mustGet()->getRequest();
        $cookieParams=$request->getCookieParams();
        $unique_code=isset($cookieParams['code'])?$cookieParams['code']:'';
        $key='message:github:user:'.$unique_code;
        $is_login=$unique_code && Redis::get($key)?1:0;

        if ($request->isPost()) {   //Post传值
            // Do something
            if($is_login==0){
                $content=array('status'=> 112,'msg'=> '尚未登录！',);
                return Context::mustGet()
                    ->getResponse()
                    ->withContentType(ContentType::HTML)
                    ->withContent(json_encode($content));
            }
            $data = $request->post();
            $msg = htmlspecialchars(trim($request->post('msg')));
            if (empty($msg)) {
                $content=json_encode(['status'=> 100,'msg'=> '留言内容不能为空！',]);
                return Context::mustGet()
                    ->getResponse()
                    ->withContentType(ContentType::HTML)
                    ->withContent($content);
            }

            //入库
            $message = Message::new();
            $message->setTitle($msg);
            $message->setContent($msg);
            $curTime=time();
            $message->setTmCreate($curTime);
            $message->setTmUpdate($curTime);
            $id  = $message->save();
            $content=$id?json_encode(['status'=> 1,'msg'=> '留言成功！',]):json_encode(['status'=> 101,'msg'=> '留言失败！',]);
            return Context::mustGet()
                ->getResponse()
                ->withContentType(ContentType::HTML)
                ->withContent($content);
        }

        $page=(int)$page>0?$page:1;
        $page_size=10;
        $total_count=DB::table('message')->count();
        if (ceil($total_count/$page_size)<$page) {
            $page=(int)ceil($total_count/$page_size);
        }
        // $message_list = DB::table('message')->orderBy('tm_update', 'desc')->forPage($page, $page_size)->get();
        $message_list = Message::forPage($page, $page_size)->orderByDesc('tm_update')->get(['id', 'title','content','tm_update']);

        /* @var Message $message */
        $list=array();
        foreach ($message_list as  $el) {
            $id=$el->getId();
            $list[] = array(
                'id'=> $id,
                'title'=> $el->getTitle(),
                'content'=> $el->getContent(),
                'tm_update'=> $el['tm_update']?date('Y-m-d H:i:s', $el['tm_update']):'',
                'class'=> getColorList($id),
            );
        }

        $url='/message/';
        $redirect_url='https://github.com/login/oauth/authorize?client_id='.$this->client_id.'&redirect_uri='.$this->client_callback;
        $data = [
            'url'=> $redirect_url,
            'title'=> '留言板',
            'message_list' => $list,
            'page'=> getPageList($page, $page_size, $total_count, $url),
            'is_login'=> $is_login,
        ];

        // 将会渲染 `resource/views/site/index.php` 文件
        return view('message/index', $data);
    }


    /**
     * @RequestMapping("/message/add")
     * @throws Throwable
     */
    public function add(): Response
    {
        $message = Message::new();
        $message->setTitle('测试34565');
        $message->setContent('this my desc');
        $id  = $message->save();
        $users = DB::table('message')->get();
        $content=json_encode($users);
        return Context::mustGet()
            ->getResponse()
            ->withContentType(ContentType::HTML)
            ->withContent($content);
    }


    /**
     * @RequestMapping("/message/demo")
     * @throws Throwable
     */
    public function demo(): Response
    {
        // $response->detach();
        // $response->cookie('key','123',3600);
        $request = \Swoft\Context\Context::mustGet()->getRequest();
        $header = $request->getCookieParams();
        $content=array(
            'code'=> isset($header['code'])?$header['code']:'',
        );
        return Context::mustGet()
            ->getResponse()
            ->withContentType(ContentType::HTML)
           ->withData($content);
    }


    /**
     * @RequestMapping("callback")
     * @throws Throwable
     */
    public function callback(): Response
    {
        $request = \Swoft\Context\Context::mustGet()->getRequest();
        $cookieParams=$request->getCookieParams();
        $unique_code=isset($cookieParams['code'])?$cookieParams['code']:'';
        $key='message:github:user:'.$unique_code;
        if($unique_code && Redis::get($key)){
            $response = \Swoft\Context\Context::mustGet()->getResponse();
            return $response->redirect("/message/2", 302);
        }

        $code=$request->get('code');
        if (isset($code) && $code) {
            $access_token_url = 'https://github.com/login/oauth/access_token';
            $params = array(
                'client_id'     => $this->client_id,
                'client_secret' => $this->client_secret,
                'code'          => $code,
            );
            $access_token = getHttpResponsePOST($access_token_url, $params);
            if ($access_token) {
                $info_url = 'https://api.github.com/user?'.$access_token;
                $data = array();
                parse_str($access_token, $data);
                $token = $data['access_token'];
                $url = "https://api.github.com/user?access_token=".$token;
                $headers[] = 'Authorization: token '.$token;
                $headers[] = "User-Agent: message_board_demo";
                $result = getHttpResponseGET($info_url, $headers);
                $info = json_decode($result, true);
                if (isset($info['id'])) {
                    $key='message:github:user:'.$code;
                    Redis::set($key, (string)$info['id'],7200);
                    $response = \Swoft\Context\Context::mustGet()->getResponse();
                    $cookie_set='code='.$code;
                    return $response->withHeader("Set-Cookie", $cookie_set)->redirect("/message", 302);
                }
            }
        }

        $content=array('status'=> 111,'msg'=> '登录失败！',);
        return Context::mustGet()
            ->getResponse()
            ->withContentType(ContentType::HTML)
            ->withContent(json_encode($content));
    }
}
