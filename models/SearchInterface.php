<?php

namespace app\models;

interface SearchInterface
{
    public function search($params);
    public function searchFields();
    public function getData();
    public function ExportColumns();
    public function tableColumns();
    public function scenarios();
}
