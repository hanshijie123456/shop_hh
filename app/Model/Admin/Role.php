<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
      //
    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 'role';

    //主键
    protected $primaryKey = 'id';

    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    /**
	 * 不可被批量赋值的属性。
	 *
	 * @var array
	 */
	protected $guarded = [];

     /**
     * 获得此用户的角色权限。
     */
    public function permissions()
    {
        return $this->belongsToMany('App\Model\Admin\Permission','role_permission','role_id','per_id');
    }
}
