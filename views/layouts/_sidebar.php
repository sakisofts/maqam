<!-- Bootstrap 5 Sidebar Menu -->

<?php
use yii\helpers\Url;

?>
<nav id="sidebar">
    <div class="list-group list-group-flush border-0">
        <!-- Dashboard -->
        <a href="<?= Url::to(['/site/index']) ?>" class="list-group-item list-group-item-action border-0 bg-transparent <?= Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'index' ? 'active text-primary' : '' ?>">
            <i class="fas fa-home me-2"></i> Dashboard
        </a>
        <!-- Bookings Dropdown -->
        <a href="#bookingsSubmenu" data-bs-toggle="collapse" aria-expanded="<?= Yii::$app->controller->id == 'booking' ? 'true' : 'false' ?>" class="list-group-item list-group-item-action border-0 bg-transparent <?= Yii::$app->controller->id == 'booking' ? 'active text-primary' : '' ?>">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-calendar-check me-2"></i> Booking
                </div>
                <i class="fas fa-chevron-down"></i>
            </div>
        </a>
        <div class="collapse <?= Yii::$app->controller->id == 'booking' ? 'show' : '' ?>" id="bookingsSubmenu">
            <div class="list-group list-group-flush border-0 ps-4">
                <a href="<?= Url::to(['/booking/index']) ?>" class="list-group-item list-group-item-action border-0 bg-transparent <?= Yii::$app->controller->id == 'booking' && Yii::$app->controller->action->id == 'index' ? 'active text-primary' : '' ?>">
                    <i class="fas fa-list me-2"></i> Booking
                </a>
                <a href="<?= Url::to(['/booking/reserve']) ?>" class="list-group-item list-group-item-action border-0 bg-transparent <?= Yii::$app->controller->id == 'booking' && Yii::$app->controller->action->id == 'reservation' ? 'active text-primary' : '' ?>">
                    <i class="fas fa-bank me-2"></i> Reserve
                </a>
                <a href="<?= Url::to(['/booking/ots']) ?>" class="list-group-item list-group-item-action border-0 bg-transparent <?= Yii::$app->controller->id == 'booking' && Yii::$app->controller->action->id == 'ots' ? 'active text-primary' : '' ?>">
                    <i class="fas fa-clock me-2"></i> One Time Service
                </a>
<!--                <a href="--><?php //= Url::to(['/booking/app']) ?><!--" class="list-group-item list-group-item-action border-0 bg-transparent --><?php //= Yii::$app->controller->id == 'booking' && Yii::$app->controller->action->id == 'app' ? 'active text-primary' : '' ?><!--">-->
<!--                    <i class="fas fa-mobile-alt me-2"></i> Via App-->
<!--                </a>-->
<!--                <a href="--><?php //= Url::to(['/booking/regular']) ?><!--" class="list-group-item list-group-item-action border-0 bg-transparent --><?php //= Yii::$app->controller->id == 'booking' && Yii::$app->controller->action->id == 'regular' ? 'active text-primary' : '' ?><!--">-->
<!--                    <i class="fas fa-user-friends me-2"></i> Regular-->
<!--                </a>-->
                <a href="<?= Url::to(['/booking/sonda-mpola']) ?>" class="list-group-item list-group-item-action border-0 bg-transparent <?= Yii::$app->controller->id == 'booking' && Yii::$app->controller->action->id == 'sonda-mpola' ? 'active text-primary' : '' ?>">
                    <i class="fas fa-plane me-2"></i> Sonda Mpola
                </a>
            </div>
        </div>
<!--        transaction -->
        <a href="<?= Url::to(['/transactions/index']) ?>" class="list-group-item list-group-item-action border-0 bg-transparent <?= Yii::$app->controller->id == 'transactions'  ? 'active text-primary' : '' ?>">
            <i class="fas fa-credit-card me-2"></i> Incoming Payment
        </a>
<!--       clients -->
        <a href="<?= Url::to(['/site/clients']) ?>" class="list-group-item list-group-item-action border-0 bg-transparent <?= Yii::$app->controller->id == 'users' && Yii::$app->controller->action->id == 'clients' ? 'active text-primary' : '' ?>">
            <i class="fas fa-user-circle me-2"></i> Customers
        </a>
        <!-- Adverts -->
        <a href="<?= Url::to(['/advert/index']) ?>" class="list-group-item list-group-item-action border-0 bg-transparent <?= Yii::$app->controller->id == 'advert' ? 'active text-primary' : '' ?>">
            <i class="fas fa-ad me-2"></i> Adverts
        </a>

        <!-- Packages -->


        <a href="#packagesSubmenu" data-bs-toggle="collapse" aria-expanded="<?= Yii::$app->controller->id == 'package' ? 'true' : 'false' ?>" class="list-group-item list-group-item-action border-0 bg-transparent <?= Yii::$app->controller->id == 'package' ? 'active text-primary' : '' ?>">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-calendar-check me-2"></i> Packages
                </div>
                <i class="fas fa-chevron-down"></i>
            </div>
        </a>
        <div class="collapse <?= Yii::$app->controller->id == 'package' ? 'show' : '' ?>" id="packagesSubmenu">
            <div class="list-group list-group-flush border-0 ps-4">
                <a href="<?= Url::to(['/package/master']) ?>" class="list-group-item list-group-item-action border-0 bg-transparent <?= Yii::$app->controller->id == 'package' && Yii::$app->controller->action->id=="master" ? 'active text-primary' : '' ?>">
                    <i class="fas fa-box me-2"></i> Master Packages
                </a>
                <a href="<?= Url::to(['/package/index']) ?>" class="list-group-item list-group-item-action border-0 bg-transparent <?= Yii::$app->controller->id == 'package' && Yii::$app->controller->action->id=="index" ? 'active text-primary' : '' ?>">
                    <i class="fas fa-box me-2"></i> Running Packages
                </a>
            </div>
        </div>



        <!-- Maqam Experience -->
        <a href="<?= Url::to(['/experience/index']) ?>" class="list-group-item list-group-item-action border-0 bg-transparent <?= Yii::$app->controller->id == 'experience' ? 'active text-primary' : '' ?>">
            <i class="fas fa-star me-2"></i> Maqam Experience
        </a>
        <a href="<?= Url::to(['/booking/amenities']) ?>" class="list-group-item list-group-item-action border-0 bg-transparent <?= Yii::$app->controller->id == 'booking' && Yii::$app->controller->action->id="amenities" ? 'active text-primary' : '' ?>">
            <i class="fas fa-address-book me-2"></i> Amenities
        </a>
        <!-- Maqam Experience -->
        <a href="<?= Url::to(['/site/users']) ?>" class="list-group-item list-group-item-action border-0 bg-transparent <?= Yii::$app->controller->id == 'users' ? 'active text-primary' : '' ?>">
            <i class="fas fa-user me-2"></i> System User
        </a>
    </div>
</nav>

<!-- Add custom CSS to override Bootstrap's default background colors -->
<style>
    /* Remove default background colors and box shadows */
    #sidebar .list-group-item {
        background-color: transparent !important;
        box-shadow: none !important;
    }

    /* Change active style to use only text color instead of background */


    /* Remove any borders */
    #sidebar .list-group,
    #sidebar .list-group-item {
        border: none;
        color:#fff;
        transition: 0.3s ease ;

    }

    /* Handle animation for dropdown chevron */
    .collapse.show + a .fa-chevron-down,
    [aria-expanded="true"] .fa-chevron-down {
        transform: rotate(180deg);
        transition: transform 0.3s ease;
    }

    .fa-chevron-down {
        transition: transform 0.3s ease;
    }

    /* Add subtle hover effect without changing background */
    #sidebar .list-group-item:hover {
        font-weight: bolder;
    }
</style>
