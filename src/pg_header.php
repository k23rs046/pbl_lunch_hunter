<!-- ヘッダー -->
<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="Content-TYPE" content="text/html; charset=UTF-8">
  <link rel="stylesheet" TYPE="text/css" href="css/style.css">
  <style>
    body {
      font-family: sans-serif;
      margin: 0;
      background: #f7f7f7;
    }

    header {
      background: #fff;
      border-bottom: 1px solid #ccc;
      padding: 10px;
      display: flex;
      justify-content: space-between;
    }

    header .left a {
      color: #b91c1c;
      text-decoration: none;
    }

    header .right a {
      margin-left: 15px;
      text-decoration: none;
      color: #333;
    }

    main {
      max-width: 1000px;
      margin: 20px auto;
      padding: 0 15px;
    }

    /* 検索フォーム */
    .search-box {
      background: #fff;
      padding: 15px;
      border: 1px solid #ddd;
      margin-bottom: 20px;
    }

    .search-box input[type=text] {
      width: 60%;
      padding: 5px;
    }

    .search-box button {
      margin-left: 5px;
    }

    .genre-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 5px;
      margin: 10px 0;
    }

    /* 店舗カード一覧 */
    .store-list {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 15px;
    }

    .store {
      background: #fff;
      border: 1px solid #ddd;
      border-radius: 6px;
      overflow: hidden;
    }

    .store img {
      width: 100%;
      height: 150px;
      object-fit: cover;
    }

    .store .info {
      padding: 10px;
    }

    .store .info div {
      margin-bottom: 5px;
    }

    .store .rating {
      color: #d97706;
      font-weight: bold;
    }

    /* ページネーション */
    .pagination {
      text-align: center;
      margin-top: 20px;
    }

    .pagination a {
      margin: 0 5px;
      text-decoration: none;
      color: #333;
    }

    .pagination a.active {
      font-weight: bold;
      color: #0366d6;
    }

    /* ボタン風リンク */
    .btn-secondary {
      background: #e5e7eb;
      color: #111;
      padding: 6px 10px;
      border-radius: 6px;
      text-decoration: none;
    }
  </style>
</head>

<body>
  <header>
    <div class="wrapper">
      <div id="navbar">

        <?php
        function h($str)
        {
          return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
        }
        echo $_SESSION['user_account'] ?? '', ' &nbsp;&nbsp;&nbsp;';
        if (isset($_SESSION['usertype_id'])) {

          $menu = array(); //メニュー項目：プログラム名（拡張子.php省略）
          if ($_SESSION['usertype_id'] === '1') {  //社員
            $menu = array(   //社員メニュー
              '店舗一覧'  => 'rst_list',
              'MY_PAGE'  => 'user_page',
              '店舗登録'  => 'rst_input',
            );
          }
          if ($_SESSION['usertype_id'] === '9') {  //管理者
            $menu = array(   //管理者メニュー
              '店舗一覧'  => 'rst_list',
              'ユーザ登録' => 'user_input',
              'ユーザ一覧'  => 'user_list',
              '通報済み口コミ一覧' => 'rev_report',
            );
          }

          echo '<div class="right">';
          foreach ($menu as $label => $action) {
            echo  '<a href="?do=' . $action . '">' . $label . '</a>&nbsp;&nbsp;';
          }
          echo '</div>';
          echo '<div class="left">';
          echo  '<a href="?do=user_logout">ログアウト</a>&nbsp;&nbsp;';
          echo '</div>';
        } else {
          echo '<div class="left">';
          echo  '<a href="?do=user_login">ログイン</a>';
          echo '</div>';
        }
        ?>
      </div>
  </header>
  <h2 align="left">Lunch Hunter</h2>