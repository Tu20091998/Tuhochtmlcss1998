const API_URL = "http://localhost:4001/products";

async function loadProducts() {
    try {
        const res = await fetch(API_URL);
        if (!res.ok) throw new Error("Không tải được sản phẩm!");
        
        const products = await res.json();
        const container = document.getElementById("product-list");
        
        container.innerHTML = products.map(p => `
            <div class="product">
                <img src="${p.image}" alt="${p.name}">
                <h3>${p.name}</h3>
                <p>Giá: ${p.price.toLocaleString()}₫</p>
            </div>
        `).join("");
    } catch (err) {
        console.error(err);
    }
}

loadProducts();