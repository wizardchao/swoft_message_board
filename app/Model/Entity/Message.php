<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;

/**
 * Class Message
 *
 * @since 2.0
 *
 * @Entity(table="message")
 */
class Message extends Model
{
    /**
     * @Id(incrementing=true)
     *
     * @Column(name="id", prop="id")
     * @var int|null
     */
    private $id;

    /**
     * @Column()
     * @var string|null
     */
    private $title;

    /**
     * @Column()
     * @var string|null
     */
    private $content;

    /**
     * @Column()
     *
     * @var int|null
     */
    private $tm_create;

    /**
     * @Column()
     * @var int|null
     */
    private $tm_update;

    /**
     * @Column()
     * @var int|null
     */
    private $status;


    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }


    /**
     * @param string|null $content
     */
    public function setContent(?string $content): void
    {
        $this->content = $content;
    }


    /**
     * [getTotalCount description]
     * @param  array  $param [description]
     * @return [type]        [description]
     */
    public static function getTotalCount($param=array())
    {
        if (!isset($param['status'])) {
            $param['status']=1;
        }
        return $this->where($param)->count();
    }
}
