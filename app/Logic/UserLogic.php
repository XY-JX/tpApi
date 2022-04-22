<?php

namespace app\Logic;

use app\model\User;

class UserLogic
{
    /**
     * 列表查询
     * @param array $param
     * @return array
     */
    public function list(array $param): array
    {
        $where = $this->where($param);
        $field = ['id', 'nickname', 'sex'];
        return User::where($where)
            ->field($field)
            ->order('id', 'desc')
            ->select()
            // ->paginate()
            ->toArray();
    }

    /**
     * 新增
     * @param array $param
     * @return int|string
     */
    public function add(array $param)
    {
        return User::insert($param, 'id');
    }

    /**
     * 编辑
     * @param array $param
     * @return User
     */
    public function edit(array $param)
    {
        return User::update($param);
    }

    /**
     * 删除
     * @param $id
     * @return User
     */
    public function del($id)
    {
        return User::where('id', $id)->update(['df' => 1]);
    }

    /**
     * 详情
     * @param $id
     * @return User|array|mixed|\think\Model|null
     */
    public function info($id)
    {
        return User::where('id', $id)->field(['id', 'nickname', 'sex'])->find();
    }

    /**
     * 查询条件组装
     * @param array $param
     * @return array
     */
    private function where(array $param): array
    {
        $where = [['df', '=', BaseModel::DF]];
        return $param;
    }
}