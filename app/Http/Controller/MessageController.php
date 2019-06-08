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

/**
 * Class MessageController
 * @Controller()
 */
class MessageController
{
    /**
     * @RequestMapping("/message[/{page}]")
     * @param int $page
     * @return Response
     * @throws ReflectionException
     * @throws ContainerException
     */
    public function index(int $page): Response
    {
        $page=$page?:1;
        $page_size=2;
        $total_count=DB::table('message')->count();
        // $total_count=Message::getTotalCount();
        $message_list = Message::forPage($page, $page_size)->get(['id', 'title','content'])->keyBy('id');

        /* @var Message $message */
        $list=array();
        foreach ($message_list as $id => $el) {
            $list[] = array(
                'id'=> $id,
                'title'=> $el->getTitle(),
                'content'=> $el->getContent(),
                'class'=> getColorList($id),
            );
        }

        $url='/message/';
        $data = [
            'message_list' => $list,
            'page'=> getPageList($page, $page_size, $total_count, $url),
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
        $message->setTitle('测试');
        $message->setContent('this my desc');
        $id  = $message->save();
        $users = DB::table('message')->get();
        $content=json_encode($users);
        return Context::mustGet()
            ->getResponse()
            ->withContentType(ContentType::HTML)
            ->withContent($content);
    }
}
