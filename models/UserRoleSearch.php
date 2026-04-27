<?php

namespace app\models;

class UserRoleSearch extends UserRoles implements SearchInterface
{

    public function scenarios()
    {
        return parent::scenarios();
    }

    public function search($params=null)
    {
        if($params){
            $this->load($params);
        }

        // TODO: Implement search() method.
    }

    public function searchFields()
    {
        // TODO: Implement searchFields() method.
    }

    public function getData()
    {
        // TODO: Implement getData() method.
    }

    public function ExportColumns()
    {
        // TODO: Implement ExportColumns() method.
    }

    public function tableColumns()
    {
        // TODO: Implement tableColumns() method.
    }
}
