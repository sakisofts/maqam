<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $email_verified_at
 * @property string|null $password
 * @property int $role
 * @property string|null $gender
 * @property string|null $dob
 * @property string|null $nationality
 * @property string|null $residence
 * @property string|null $NIN_or_Passport
 * @property string|null $passportPhoto
 * @property string|null $remember_token
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $status
 * @property int|null $two_factor_enabled
 * @property string|null $password_changed_at
 * @property string|null $email_change_token
 * @property int|null $notify_login
 * @property int|null $notify_updates
 * @property int|null $notify_news
 * @property string|null $new_email
 * @property int|null $web_notify_login
 * @property int|null $web_notify_updates
 * @property int|null $web_notify_messages
 * @property int|null $web_notify_news
 * @property int|null $push_notify_login
 * @property int|null $push_notify_updates
 * @property int|null $push_notify_messages
 * @property int|null $push_notify_news
 */
class Users extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'phone', 'email_verified_at', 'password', 'gender', 'dob', 'nationality', 'residence', 'NIN_or_Passport', 'passportPhoto', 'remember_token', 'created_at', 'updated_at', 'email_change_token', 'new_email'], 'default', 'value' => null],
            [['push_notify_news'], 'default', 'value' => 0],
            [['email_verified_at', 'created_at', 'updated_at', 'password_changed_at'], 'safe'],
            [['role'], 'required'],
            [['role', 'status', 'two_factor_enabled', 'notify_login', 'notify_updates', 'notify_news', 'web_notify_login', 'web_notify_updates', 'web_notify_messages', 'web_notify_news', 'push_notify_login', 'push_notify_updates', 'push_notify_messages', 'push_notify_news'], 'integer'],
            [['name', 'email', 'phone', 'password', 'gender', 'dob', 'nationality', 'residence', 'NIN_or_Passport', 'passportPhoto'], 'string', 'max' => 119],
            [['remember_token'], 'string', 'max' => 100],
            [['email_change_token', 'new_email'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['phone'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'email_verified_at' => 'Email Verified At',
            'password' => 'Password',
            'role' => 'Role',
            'gender' => 'Gender',
            'dob' => 'Dob',
            'nationality' => 'Nationality',
            'residence' => 'Residence',
            'NIN_or_Passport' => 'Nin Or Passport',
            'passportPhoto' => 'Passport Photo',
            'remember_token' => 'Remember Token',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
            'two_factor_enabled' => 'Two Factor Enabled',
            'password_changed_at' => 'Password Changed At',
            'email_change_token' => 'Email Change Token',
            'notify_login' => 'Notify Login',
            'notify_updates' => 'Notify Updates',
            'notify_news' => 'Notify News',
            'new_email' => 'New Email',
            'web_notify_login' => 'Web Notify Login',
            'web_notify_updates' => 'Web Notify Updates',
            'web_notify_messages' => 'Web Notify Messages',
            'web_notify_news' => 'Web Notify News',
            'push_notify_login' => 'Push Notify Login',
            'push_notify_updates' => 'Push Notify Updates',
            'push_notify_messages' => 'Push Notify Messages',
            'push_notify_news' => 'Push Notify News',
        ];
    }

    public function userStats(){
        $last7Days = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));

            $count = Users::find()
                ->where(['between', 'created_at', $date . ' 00:00:00', $date . ' 23:59:59'])
                ->count();

            $last7Days[] = [
                'date' => $date,
                'count' => $count
            ];
        }

        // Get active/inactive user counts
        $activeUsers = Users::find()->where(['status' => 1])->count();
        $inactiveUsers = Users::find()->where(['status' => 0])->count();

        // Get users breakdown by role
        $usersByRole = Users::find()
            ->select(['role', 'COUNT(*) as count'])
            ->groupBy(['role'])
            ->asArray()
            ->all();

        $twoFactorEnabled = Users::find()->where(['two_factor_enabled' => 1])->count();

        return [
            'daily_registrations' => $last7Days,
            'active_users' => $activeUsers,
            'inactive_users' => $inactiveUsers,
            'users_by_role' => $usersByRole,
            'two_factor_enabled' => $twoFactorEnabled,
            'timestamp' => date('Y-m-d H:i:s')
        ];
    }

    public function DailyStat(){
        $totalUsers = Users::find()->count();
        // Get yesterday's date
        $yesterday = date('Y-m-d', strtotime('-1 day'));
        $today = date('Y-m-d');

        // Count users created yesterday
        $usersYesterday = Users::find()
            ->where(['between', 'created_at', $yesterday . ' 00:00:00', $yesterday . ' 23:59:59'])
            ->count();

        // Count users created today
        $usersToday = Users::find()
            ->where(['between', 'created_at', $today . ' 00:00:00', $today . ' 23:59:59'])
            ->count();

        // Calculate percentage change
        $percentChange = 0;
        if ($usersYesterday > 0) {
            $change = $usersToday - $usersYesterday;
            $percentChange = round(($change / $usersYesterday) * 100);
        }

        return [
            'total_users' => $totalUsers,
            'new_users_today' => $usersToday,
            'new_users_yesterday' => $usersYesterday,
            'percent_change' => $percentChange,
            'timestamp' => date('Y-m-d H:i:s')
        ];

    }

}
