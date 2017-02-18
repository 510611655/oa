<?php
namespace Admin\Model;
use Think\Model;
class EmailModel extends Model{
    //自定义字段
    protected $fields=array(
        'id','title','content','send_id','receiver_id','send_time','file','is_read'
    );
    protected $pk="id";


}