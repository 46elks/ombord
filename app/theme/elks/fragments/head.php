<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i,700,900" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Alegreya:ital,wght@1,500&family=Cairo&family=Comfortaa:wght@300&family=Montserrat:wght@500&family=Secular+One&family=Ubuntu+Mono&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/css/style.css">
  <script src="/js/jquery-1.12.4.min.js"></script>
  <script src="/js/query-ui-1.12.1.min.js"></script>
  <script src="/js/script.js"></script>
  <script src="/js/tasks.js"></script>
  <script src="/js/lists.js"></script>

  <title>Ombord</title>
</head>

<body>

  <header id="header" class="">
    <div class="outer-wrapper">
      <div class="inner-wrapper">
        <div class="row">
          <?php if(isset($data['breadcrumbs'])): ?>
            <nav class="breadcrumbs">
              <ul class="inline-list">
                <?php foreach ($data['breadcrumbs'] as $key => $crumb) :?>
                  <?php if(isset($crumb['url'])): ?>
                    <li class="breadcrumbs__item"><a href="<?=$crumb['url'];?>"><?=$crumb['title'];?></a></li>
                  <?php else: ?>
                    <li class="breadcrumbs__item"><?=$crumb['title'];?></li>
                  <?php endif; ?>
                <?php endforeach; ?>
              </ul>
            </nav>
          <?php else: ?>
            <nav class="breadcrumbs">
              <ul class="inline-list">
                  <li class="breadcrumbs__item"><a href="/dashboard">Ombord</a></li>
              </ul>
            </nav>
          <?php endif; ?>

          <nav class="global-nav">
            <ul class="inline-list">
              <?php if(is_logged_in()): ?>
                <li class="nav-li"><a class="nav-a" href="/logout">Logga ut</a></li>
              <?php endif; ?>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </header>