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

/**
 * Class HomeController
 * @Controller()
 */
class UserController
{
    /**
     * @RequestMapping("/user")
     * @throws Throwable
     */
    public function index(): Response
    {
        $user = User::new();
        $user->setName('name');
        // $user->;
        $user->setUserDesc('this my desc');
        $user->setAge(mt_rand(1, 100));
        $id  = $user->save();
        $users = DB::table('user')->get();
        $content=json_encode($users);
        return Context::mustGet()
            ->getResponse()
            ->withContentType(ContentType::HTML)
            ->withContent($content);
    }
}
