<?php include 'app/views/shares/header.php'; ?>
<body background="/public/images/anh-nen-website-bat-dong-san-dep-1.png" style="background-size: cover; background-position: center; background-attachment: fixed;">
<h1>Danh sách sản phẩm</h1>
<a href="/Product/add" class="btn btn-success mb-2">Thêm sản phẩm mới</a>

<!-- Bộ lọc danh mục -->
<form method="GET" id="filter-form">
    <label for="category">Lọc theo danh mục:</label>
    <select name="category" id="category" class="form-control">
        <option value="">Tất cả</option>
        <?php foreach ($categories as $category): ?>
            <option value="<?php echo $category->id; ?>" 
                <?php echo (isset($_GET['category']) && $_GET['category'] == $category->id) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>
            </option>
        <?php endforeach; ?>
    </select>
</form>

<!-- Hiển thị sản phẩm dưới dạng lưới -->
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
        <?php foreach ($products as $product): ?>
            <div class="product-item" style="border: 1px solid #ccc; padding: 15px; text-align: center;">
                <h2><a href="/Product/show/<?php echo $product->id; ?>"><?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?></a></h2>
                <img src="<?php echo htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>" style="max-width: 100px; max-height: 100px;"/>
                <p><?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?></p>
                <p>Giá: <?php echo number_format($product->price, 0, ',', '.'); ?> VND</p>
                <p>Danh mục: <?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?></p>
                <a href="/Product/edit/<?php echo $product->id; ?>" class="btn btn-warning">Sửa</a>
                <button class="btn btn-danger" onclick="deleteProduct(<?php echo $product->id; ?>)">Xóa</button>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>

<!-- Thêm JavaScript trong thẻ <script> -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const categoryFilter = document.getElementById('category');
        categoryFilter.addEventListener('change', function() {
            loadProducts(categoryFilter.value);
        });

        function loadProducts(categoryId = '') {
            const url = categoryId ? `/api/product?category=${categoryId}` : '/api/product';
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const productList = document.getElementById('product-list');
                    productList.innerHTML = ''; // Xóa danh sách sản phẩm hiện tại

                    data.forEach(product => {
                        const productItem = document.createElement('div');
                        productItem.className = 'col-md-4 product-item';  
                        productItem.innerHTML = `
                            <div class="product-item">
                                <h2><a href="/Product/show/${product.id}">${product.name}</a></h2>
                                <img src="${product.image}" alt="${product.name}" style="max-width: 100px; max-height: 100px;"/>
                                <p>${product.description}</p>
                                <p>Giá: ${product.price} VND</p>
                                <p>Danh mục: ${product.category_name}</p>
                                <a href="/Product/edit/${product.id}" class="btn btn-warning">Sửa</a>
                                <button class="btn btn-danger" onclick="deleteProduct(${product.id})">Xóa</button>
                            </div>
                        `;
                        productList.appendChild(productItem);
                    });
                });
        }

        const categoryId = new URLSearchParams(window.location.search).get('category');
        loadProducts(categoryId);
    });

    function deleteProduct(id) {
        if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) {
            fetch(`/api/product/${id}`, {
                method: 'DELETE'
            })
            .then(response => response.json())
            .then(data => {
                if (data.message === 'Product deleted successfully') {
                    location.reload();
                } else {
                    alert('Xóa sản phẩm thất bại');
                }
            });
        }
    }
</script>
