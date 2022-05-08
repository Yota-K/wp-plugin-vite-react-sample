<?php
if (!class_exists('CreateAdminPage')):

class CreateAdminPage {
  public function __construct()
  {
    if (is_admin()) {
      add_action('admin_menu', [$this, 'admin_menu']);
      add_action('admin_enqueue_scripts', [$this, 'include_home_resources']);
    }
  }

  // メインメニュー
  public function admin_menu()
  {
    add_menu_page(
      'sample', /* ページタイトル*/
      'sample', /* メニュータイトル */
      'manage_options', /* 権限 */
      'sample-plugin', /* ページを開いたときのurl */
      [$this, 'home_page'], /* メニューに紐づく画面を描画するcallback関数 */
      'dashicons-media-text', /* アイコン */
      3, /* 表示位置の優先度 */
    );
  }

  // ホーム画面で使用するCSS・JSを読み込ませる
  public function include_home_resources()
  {
    $plugin_url = plugin_dir_url(__FILE__);
    $current_page_url = (empty($_SERVER['HTTPS']) ? 'http://' : 'https://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    // プラグインのホーム画面でのみCSS・JSを読み込ませる
    if (preg_match('/admin\.php\?page=sample-plugin$/u', $current_page_url)) {
      wp_enqueue_style('sample-plugin-css', $plugin_url . 'front/dist/assets/index.css', [], wp_rand());
      wp_enqueue_script('sample-plugin-js', $plugin_url . 'front/dist/assets/index.js', ['jquery', 'wp-element'], wp_rand(), true);
    }
  }

  // ホーム画面
  public function home_page()
  {
    echo '<div id="vite-react-sample"></div>';
  }
}

new CreateAdminPage();

endif;
