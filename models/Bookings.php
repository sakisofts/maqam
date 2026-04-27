<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\Json;

/**
 * This is the model class for table "bookings".
 *
 * @property int $id
 * @property int $userId
 * @property int $packageId
 * @property string $name
 * @property string $email
 * @property string $category
 * @property string|null $paymentOption
 * @property string|null $travelDocument
 * @property string|null $is_archived
 * @property string|null $status
 * @property string|null $c_year
 * @property string|null $created_at
 * @property string|null $created_by
 * @property string|null $updated_at
 */
class Bookings extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'bookings';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => false,
                'value' => new Expression('NOW()'),
            ],
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => false,
                'value' => Yii::$app->user->identity->id,
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['paymentOption', 'travelDocument', 'bookingType','created_by', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['userId', 'packageId'], 'required'],
            [['userId', 'packageId'], 'integer'],
            [['created_at', 'updated_at', 'name','c_year','status','is_archived', 'email', 'category', 'paymentOption', 'payment_status'], 'safe'],
            [['paymentOption', 'travelDocument'], 'string', 'max' => 255],
            [['bookingType'], 'string', 'max' => 119],
            [['name', 'email'], 'required'],
            ['email', 'email'],
            // Check for unique userId and packageId combination
            [['userId', 'packageId'], 'unique', 'targetAttribute' => ['userId', 'packageId'], 'message' => 'This user already has a booking for this package.'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userId' => 'User',
            'packageId' => 'Package',
            'name' => 'Full Name',
            'email' => 'Email Address',
            'paymentOption' => 'Payment Method',
            'travelDocument' => 'Travel Document',
            'bookingType' => 'Booking Type',
            'status' => 'Status',
            'is_archived' => 'Is Archived',
            'created_at' => 'Created At',
            'c_year' => 'Current year',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Get related user
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'userId']);
    }

    /**
     * Get related package
     * @return \yii\db\ActiveQuery
     */
    public function getPackage()
    {
        return $this->hasOne(Packages::class, ['id' => 'packageId']);
    }

    /**
     * Check if a booking with the same user and package already exists
     * @param integer $userId
     * @param integer $packageId
     * @param integer $excludeId Optional ID to exclude from the check (for updates)
     * @return boolean
     */
    public static function bookingExists($userId, $packageId, $excludeId = null)
    {
        $query = self::find()->where([
            'userId' => $userId,
            'packageId' => $packageId,
        ]);

        if ($excludeId !== null) {
            $query->andWhere(['!=', 'id', $excludeId]);
        }

        return $query->exists();
    }

    /**
     * Returns payment option list
     * @return array
     */
    public static function getPaymentOptions()
    {
        return [
            'cash' => 'Cash',
            'card' => 'Card',
            'bank_transfer' => 'Bank Transfer',
            'airtel_money' => 'Airtel Money',
            'mpesa' => 'M-Pesa'
        ];
    }

    /**
     * Returns booking type list
     * @return array
     */
    public static function getBookingTypes()
    {
        return [
            'individual' => 'Individual',
            'group' => 'Group',
            'family' => 'Family'
        ];
    }

    /**
     * Returns category list
     * @return array
     */
    public static function getCategories()
    {
        return [
            'hajj' => 'Hajj',
            'umrah' => 'Umrah',
            'other' => 'Other'
        ];
    }

    /**
     * Returns payment status list
     * @return array
     */
    public static function getPaymentStatuses()
    {
        return [
            'pending' => 'Pending',
            'partial' => 'Partial',
            'complete' => 'Complete',
            'cancelled' => 'Cancelled'
        ];
    }

 public function weeklyStats($startDate, $endDate){
     return Bookings::find()
         ->select([
             'day_name' => new Expression('DAYNAME(created_at)'),
             'day_num' => new Expression('DAYOFWEEK(created_at)'),
             'count' => new Expression('COUNT(*)')
         ])
         ->where(['between', 'created_at', $startDate, $endDate])
         ->groupBy(['day_name'])
         ->orderBy(['day_num' => SORT_ASC]);
 }

    public function bookings($period = 'weekly'){
        $data = [];
        switch ($period) {
            case 'weekly':
                $data = $this->getWeeklyBookings();
                break;
            case 'monthly':
                $data = $this->getMonthlyBookings();
                break;
            case 'yearly':
                $data = $this->getYearlyBookings();
                break;
            default:
                $data =[65, 59, 80, 81, 56, 55, 40];
        }

        $labels = [];
        $bookingsData = [];
        foreach ($data as $item) {
            $labels[] = $item['name'];
            $bookingsData[] = $item['Bookings'];
        }
        return  [
            'labels' => $labels,
            'bookingsData' => $bookingsData,
            'user'=>(new Users())->DailyStat()
        ];
    }


    private function getWeeklyBookings()
    {
        // Get the start and end dates for the current week (Monday to Sunday)
        $startDate = date('Y-m-d', strtotime('monday this week'));
        $endDate = date('Y-m-d', strtotime('sunday this week'));

        // Method 1: Use ANY_VALUE to handle ONLY_FULL_GROUP_BY mode
        $query = self::find()
            ->select([
                new Expression('DATE_FORMAT(created_at, "%a") as day_short'),
                new Expression('DAYOFWEEK(created_at) as day_num'),
                new Expression('COUNT(*) as count')
            ])
            ->where(['between', 'created_at', $startDate, $endDate])
            ->groupBy(['day_short', 'day_num'])
            ->orderBy(['day_num' => SORT_ASC]);

        $results = $query->asArray()->all();

        // Format the data for the chart - Initialize all days of week
        $chartData = [
            ['name' => 'Mon', 'Bookings' => 0],
            ['name' => 'Tue', 'Bookings' => 0],
            ['name' => 'Wed', 'Bookings' => 0],
            ['name' => 'Thu', 'Bookings' => 0],
            ['name' => 'Fri', 'Bookings' => 0],
            ['name' => 'Sat', 'Bookings' => 0],
            ['name' => 'Sun', 'Bookings' => 0]
        ];

        // Fill in actual counts from query
        foreach ($results as $row) {
            // Map 3-letter day abbreviation to index (0=Mon, 1=Tue, etc.)
            $dayMap = [
                'Mon' => 0, 'Tue' => 1, 'Wed' => 2, 'Thu' => 3,
                'Fri' => 4, 'Sat' => 5, 'Sun' => 6
            ];

            $dayIndex = $dayMap[$row['day_short']] ?? null;
            if ($dayIndex !== null) {
                $chartData[$dayIndex]['Bookings'] = (int)$row['count'];
            }
        }

        return $chartData;
    }

    /**
     * Alternative method using direct SQL to avoid ONLY_FULL_GROUP_BY issues
     * @return array
     */
    private function getWeeklyBookingsAlt()
    {
        $startDate = date('Y-m-d', strtotime('monday this week'));
        $endDate = date('Y-m-d', strtotime('sunday this week'));

        // Direct SQL query to avoid GROUP BY issues
        $sql = "
            SELECT 
                DATE_FORMAT(created_at, '%a') as day_short,
                COUNT(*) as count 
            FROM bookings 
            WHERE created_at BETWEEN :start AND :end 
            GROUP BY DATE_FORMAT(created_at, '%a') 
            ORDER BY FIELD(DATE_FORMAT(created_at, '%a'), 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun')
        ";

        $results = Yii::$app->db->createCommand($sql)
            ->bindValue(':start', $startDate)
            ->bindValue(':end', $endDate)
            ->queryAll();

        // Initialize all days
        $chartData = [
            ['name' => 'Mon', 'Bookings' => 0],
            ['name' => 'Tue', 'Bookings' => 0],
            ['name' => 'Wed', 'Bookings' => 0],
            ['name' => 'Thu', 'Bookings' => 0],
            ['name' => 'Fri', 'Bookings' => 0],
            ['name' => 'Sat', 'Bookings' => 0],
            ['name' => 'Sun', 'Bookings' => 0]
        ];

        // Fill in actual counts
        $dayMap = ['Mon' => 0, 'Tue' => 1, 'Wed' => 2, 'Thu' => 3, 'Fri' => 4, 'Sat' => 5, 'Sun' => 6];
        foreach ($results as $row) {
            $dayIndex = $dayMap[$row['day_short']] ?? null;
            if ($dayIndex !== null) {
                $chartData[$dayIndex]['Bookings'] = (int)$row['count'];
            }
        }

        return $chartData;
    }

    /**
     * Get bookings data grouped by day for the current month
     * @return array
     */
    private function getMonthlyBookings()
    {
        // Get the first and last day of current month
        $startDate = date('Y-m-01');
        $endDate = date('Y-m-t');

        // Query to get bookings count by day of month
        $sql = "
            SELECT 
                DAY(created_at) as day,
                COUNT(*) as count
            FROM bookings 
            WHERE created_at BETWEEN :start AND :end 
            GROUP BY DAY(created_at)
            ORDER BY day ASC
        ";

        $results = Yii::$app->db->createCommand($sql)
            ->bindValue(':start', $startDate)
            ->bindValue(':end', $endDate)
            ->queryAll();

        // Format data for chart
        $daysInMonth = date('t');
        $chartData = [];

        // Initialize all days
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $chartData[] = [
                'name' => (string)$i,
                'Bookings' => 0
            ];
        }

        // Fill in actual counts
        foreach ($results as $row) {
            $day = (int)$row['day'];
            if ($day >= 1 && $day <= $daysInMonth) {
                $chartData[$day-1]['Bookings'] = (int)$row['count'];
            }
        }

        return $chartData;
    }

    /**
     * Get bookings data grouped by month for the current year
     * @return array
     */
    private function getYearlyBookings()
    {
        // Get the first and last day of current year
        $startDate = date('Y-01-01');
        $endDate = date('Y-12-31');

        $sql = "
            SELECT 
                MONTH(created_at) as month,
                DATE_FORMAT(created_at, '%b') as month_short,
                COUNT(*) as count
            FROM bookings 
            WHERE created_at BETWEEN :start AND :end 
            GROUP BY MONTH(created_at), DATE_FORMAT(created_at, '%b')
            ORDER BY month ASC
        ";

        $results = Yii::$app->db->createCommand($sql)
            ->bindValue(':start', $startDate)
            ->bindValue(':end', $endDate)
            ->queryAll();

        // Initialize all months
        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $chartData = [];

        foreach ($monthNames as $name) {
            $chartData[] = [
                'name' => $name,
                'Bookings' => 0
            ];
        }

        // Fill in actual counts
        foreach ($results as $row) {
            $month = (int)$row['month'];
            if ($month >= 1 && $month <= 12) {
                $chartData[$month-1]['Bookings'] = (int)$row['count'];
            }
        }

        return $chartData;
    }



}
