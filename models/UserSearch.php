<?php

namespace app\models;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\helpers\Html;

class UserSearch extends User
{

    public function rules()
    {
        return [
            [['id', 'name',  'phone', 'email', 'nationality', 'created_at', 'role',], 'safe']
        ];
    }

    public function scenarios()
    {
        return parent::scenarios();
    }

    public function ql(){
        return (new Query())->from('users u')
            ->select(['u.*', 'user_roles.Role as role_name'])
            ->leftJoin('user_roles', 'u.role = user_roles.id');
    }

    public function search($params=null, $role = null)
    {
        yii::$app->session->remove("data");
        if($params){
            $this->load($params);
        }
        $query = $this->ql();

        $rid = UserRoles::find()->andFilterWhere(['like', 'LOWER(Role)', strtolower($role)])->one();
        if($rid){
            $query->andFilterWhere(['=','user_roles.role',$rid->Role]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 15,
            ],
            'sort' => [
                'attributes' => [
                    'id' => [
                        'asc' => ['b.id' => SORT_ASC],
                        'desc' => ['b.id' => SORT_DESC],
                        'default' => SORT_DESC,
                    ],
                ]
            ],
        ]);


        if (!$this->validate()) {
            return $dataProvider;
        }

        if (!empty($params['UserSearch']) && isset($params['UserSearch'])) {
            $query->andFilterWhere(['or',
                ['like', 'u.id', $this->id],
                ['like', 'u.name', $this->name],
                ['like', 'u.email', $this->email],
                ['like', 'u.nationality', $this->nationality],
            ]);
            $query->andFilterWhere(['or',

                ['like', 'LOWER(name)', strtolower($this->email)],
            ]);

        }

        yii::$app->session->set("data", $dataProvider->getModels());
        return $dataProvider;
    }

    /*
    This is a method that queries data to be exported
    */
    public function getData()
    {
        $data = yii::$app->session->get("data");
        return $data ?? $this->ql()->all();
    }

    /*
    this is a method that is used to return the columns that will be used when generating exported document
    the key defines the value that is used for iterating through data to be exported and the values is used to populated the header labels
    */

    public function exportColumns()
    {
        return [
            'email' => 'Email Address',
            'name' => 'User Name',
            'phone' => 'Phone Number',
            'residence' => 'Address',
            'nationality' => 'Nationality',
            'gender' => 'Gender',
            'created_at' => [
                'label' => 'Date Created',
                'format' => function ($value) {
                    return $value ? Yii::$app->formatter->asDate($value, 'php:Y-m-d') : '';
                }
            ]
        ];
    }

    public function tableColumns()
    {
        $col = [
            'name' => 'User Name',
            'phone' => 'Phone Number',
            'email' => 'Email Address',
            'role_name' => 'Role',
//            'is_active' => [
//                'label' => 'Status',
//                'format' => function ($data) {
//                    return $data === 0 ? "<span class='badge bg-danger-subtle text-danger'>Inactive</span>" : "<span class='badge bg-success-subtle text-success'>Active</span>";
//                }
//            ],
            'created_at' => [
                'label' => 'Date Created',
                'format' => function ($value) {
                    return $value ? Yii::$app->formatter->asDate($value, 'php:Y-m-d') : '';
                }
            ],
            'action' => [
                'label' => 'Action',
                'actions' => [
                    function ($data) {
                        return Html::a('<i class="fa fa-eye"></i>', ['user-details', 'id' => $data['id']], ['class' => 'btn btn-outline-primary btn-sm', 'title' => 'View Details']);
                    },
                    function ($data) {
                        return Html::a('<i class="fa fa-edit"></i>', ['create-user', 'id' => $data['id']], ['class' => 'btn btn-outline-primary btn-sm', 'title' => 'Update details']);
                    },
                    function ($data) {
                        return Html::a('<i class="fa fa-trash"></i>', ['delete', 'id' => $data['id']],
                            [
                                'class' => 'btn btn-outline-danger btn-sm',
                                'title' => 'Drop account',
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this item?',
                                    'method' => 'post'
                                ]
                            ]);
                    },
                ]
            ]
        ];



        return $col;
    }

    /*
    This is a method that defines the field that will be returned/ rendered for searching through the data
    */
    public function searchFields()
    {
        $fields = [
            'name' => [
                'type' => 'text',
                'placeholder' => 'Search by user name',
                'name' => 'name',
            ],
            'email' => [
                'type' => 'email',
                'placeholder' => 'Search by email',
                'name' => 'email',
            ],

        ];


        return $fields;
    }

}
