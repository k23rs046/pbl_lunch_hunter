<?php



// 検索パラメータの取得
$keyword = $_GET['keyword'] ?? '';
$sort_by = $_GET['sort_by'] ?? 'popular';
$show_discount = isset($_GET['show_discount']);
$show_favorites = isset($_GET['show_favorites']);
$selected_genres = $_GET['genres'] ?? [];
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// デモ用店舗データ
$mock_stores = [
    [
        'id' => 1,
        'name' => '丸亀製麺 九重大橋店',
        'rating' => 4.0,
        'image' => 'https://images.unsplash.com/photo-1683431686868-bdb1c683cc6d?w=400',
        'tags' => ['うどん', '和食'],
        'registered_by' => '九州健児',
        'has_discount' => false,
        'is_favorite' => false,
    ],
    [
        'id' => 2,
        'name' => '福工大前店',
        'rating' => 3.0,
        'image' => 'https://images.unsplash.com/photo-1562560471-cb5b5f96c1ab?w=400',
        'tags' => ['和食', 'その他'],
        'registered_by' => '福工',
        'has_discount' => true,
        'is_favorite' => true,
    ],
    [
        'id' => 3,
        'name' => 'カフェテリア',
        'rating' => 4.5,
        'image' => 'https://images.unsplash.com/photo-1648808694138-6706c5efc80a?w=400',
        'tags' => ['カフェ', '洋食'],
        'registered_by' => '田中',
        'has_discount' => false,
        'is_favorite' => true,
    ],
    [
        'id' => 4,
        'name' => 'とんかつ専門店',
        'rating' => 4.2,
        'image' => 'https://images.unsplash.com/photo-1625189657980-b419b768b0f6?w=400',
        'tags' => ['定食', '肉料理'],
        'registered_by' => '山田',
        'has_discount' => true,
        'is_favorite' => false,
    ],
];

$genres = ['うどん', 'そば', '肉料理', '定食', 'カレー', 'ファストフード', '焼肉', '洋食', '中華', 'カフェ', 'その他'];

$page_title = '店舗一覧 - Lunch Hunter';
require_once 'pg_header.php';
?>

<div class="store-list-container">
    
    
    <main class="main-content">
        <div class="page-header">
            <div class="page-header-row">
                <h2 class="page-title">店舗一覧</h2>
                <button onclick="toggleSearch()" style="padding: 0.5rem 1rem; background-color: white; border: 1px solid #d1d5db; border-radius: 0.375rem; cursor: pointer;">
                    <span>🔍</span> 店舗検索
                </button>
            </div>
            
            <!-- 検索パネル -->
            <div id="searchPanel" class="search-panel" style="display: none; background: white; border-radius: 0.5rem; padding: 1.5rem; margin-top: 1rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <form method="GET" class="search-form">
                    <div>
                        <label for="keyword" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">キーワード</label>
                        <input type="text" id="keyword" name="keyword" value="<?php echo h($keyword); ?>" 
                               placeholder="キーワード入力" 
                               style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                    </div>
                    
                    <div class="search-grid">
                        <div>
                            <label class="filter-label">並び替え</label>
                            <div class="filter-options">
                                <label class="filter-checkbox-group">
                                    <input type="radio" name="sort_by" value="popular" <?php echo $sort_by === 'popular' ? 'checked' : ''; ?>>
                                    人気順
                                </label>
                                <label class="filter-checkbox-group">
                                    <input type="radio" name="sort_by" value="newest" <?php echo $sort_by === 'newest' ? 'checked' : ''; ?>>
                                    新着順
                                </label>
                            </div>
                        </div>
                        
                        <div>
                            <label class="filter-label">絞り込み</label>
                            <div class="filter-options">
                                <label class="filter-checkbox-group">
                                    <input type="checkbox" name="show_discount" <?php echo $show_discount ? 'checked' : ''; ?>>
                                    割引あり
                                </label>
                                <label class="filter-checkbox-group">
                                    <input type="checkbox" name="show_favorites" <?php echo $show_favorites ? 'checked' : ''; ?>>
                                    お気に入り登録
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <label class="filter-label">ジャンル</label>
                        <div class="genre-grid">
                            <?php foreach ($genres as $genre): ?>
                                <label class="filter-checkbox-group">
                                    <input type="checkbox" name="genres[]" value="<?php echo h($genre); ?>"
                                           <?php echo in_array($genre, $selected_genres) ? 'checked' : ''; ?>>
                                    <?php echo h($genre); ?>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <div class="action-buttons">
                        <button type="button" onclick="toggleSearch()" style="padding: 0.5rem 1rem; background-color: white; border: 1px solid #d1d5db; border-radius: 0.375rem; cursor: pointer;">
                            閉じる
                        </button>
                        <button type="submit" class="action-button-primary" style="padding: 0.5rem 1rem; color: white; border-radius: 0.375rem; cursor: pointer;">
                            決定
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- 店舗カードグリッド -->
        <div class="store-grid">
            <?php foreach ($mock_stores as $store): ?>
                <div class="store-card" style="background: white; border-radius: 0.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);" onclick="location.href='store_detail.php?id=<?php echo $store['id']; ?>'">
                    <div class="store-image-container">
                        <img src="<?php echo h($store['image']); ?>" alt="<?php echo h($store['name']); ?>" class="store-image">
                        <?php if ($store['has_discount']): ?>
                            <span class="discount-badge" style="position: absolute; top: 0.5rem; right: 0.5rem; background-color: #dc2626; color: white; padding: 0.25rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem;">
                                割引
                            </span>
                        <?php endif; ?>
                        <?php if ($store['is_favorite']): ?>
                            <span style="position: absolute; top: 0.5rem; left: 0.5rem; font-size: 1.5rem;">⭐</span>
                        <?php endif; ?>
                    </div>
                    <div class="store-content">
                        <div class="store-header">
                            <h3 class="store-name"><?php echo h($store['name']); ?></h3>
                            <div class="store-rating">
                                <span>⭐</span>
                                <span><?php echo $store['rating']; ?></span>
                            </div>
                        </div>
                        <div class="store-tags">
                            <?php foreach ($store['tags'] as $tag): ?>
                                <span style="display: inline-block; background-color: #f3f4f6; padding: 0.125rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem; margin-right: 0.25rem;">
                                    #<?php echo h($tag); ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                        <p class="store-registrar">登録者：<?php echo h($store['registered_by']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- ページネーション -->
        <div class="pagination">
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <a href="?page=<?php echo $i; ?>" style="text-decoration: none;">
                    <button class="<?php echo $current_page === $i ? 'pagination-button-active' : ''; ?>" 
                            style="padding: 0.5rem 1rem; background-color: <?php echo $current_page === $i ? '#16a34a' : 'white'; ?>; 
                                   color: <?php echo $current_page === $i ? 'white' : 'black'; ?>; 
                                   border: 1px solid #d1d5db; border-radius: 0.375rem; cursor: pointer;">
                        <?php echo $i; ?>
                    </button>
                </a>
            <?php endfor; ?>
            <button disabled style="padding: 0.5rem 1rem; background-color: #f3f4f6; border: 1px solid #d1d5db; border-radius: 0.375rem; cursor: not-allowed;">
                ...10
            </button>
        </div>
    </main>
</div>

<script>
function toggleSearch() {
    const panel = document.getElementById('searchPanel');
    panel.style.display = panel.style.display === 'none' ? 'block' : 'none';
}
</script>

<?php require_once 'pg_footer.php'; ?>
