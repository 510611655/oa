<?php
namespace Admin\Model;
use Think\Model;
class DocModel extends Model{
    protected $fields=array(
        'id','title','content','author_id','file','add_time'
    );
    protected $pk='id';




}