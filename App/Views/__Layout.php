<!DOCTYPE html>
<!--suppress ALL -->
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?=$this->getViewData('title')?></title>
        <link rel="stylesheet" href="/css/bootstrap.css">
        <link rel="stylesheet" href="/css/bootstrap-theme.css">
        <link rel="stylesheet" href="/datatables/css/dataTables.bootstrap.min.css">
        <?php $this->renderSection('stylesheets'); ?>
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <?php $this->renderSection('scripts-top'); ?>
</head>
<body>
<div class="navbar">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?php /** @var App\Helpers\Html $html */
            $html->link("Application name", "index", "home", [], ['class' => 'navbar-brand']); ?>
<!--            @Html.ActionLink("Application name", "Index", "Home", new { area = "" }, new { @class = "navbar-brand" })-->
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><?php $html->link("Home", "index", "home") ?></li>
                <li><?php $html->link("Courses", "index", "courses") ?></li>
                <li><?php $html->link("Specialties", "index", "specialties") ?></li>
                <li><?php $html->link("Subjects", "index", "subjects") ?></li>
                <li><?php $html->link("Students", "index", "students") ?></li>
                <li><?php $html->link("Assessments", "index", "assessments") ?></li>
                <li><?php $html->link("Users", "index", "users") ?></li>

<!--                <li>@Html.ActionLink("Home", "Index", "Home")</li>-->
<!--                <li>@Html.ActionLink("About", "About", "Home")</li>-->
<!--                <li>@Html.ActionLink("Contact", "Contact", "Home")</li>-->
            </ul>
        </div>
    </div>
</div>
<div class="container body-content">
    <?php $this->renderBody(); ?>
    <hr />
    <footer>
        <p>&copy; 2016 - My PHP Application</p>
    </footer>
</div>

    <script type="text/javascript" src="/js/jquery.min.js"></script>
    <script type="text/javascript" src="/js/bootstrap.js"></script>
    <script type="text/javascript" src="/datatables/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="/datatables/js/dataTables.bootstrap.js"></script>

    <?php $this->renderSection('scripts-bottom'); ?>
</body>
</html>