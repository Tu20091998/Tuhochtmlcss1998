// khai báo đường dẫn tới json
const API_URL = "http://localhost:4000/products";

//json-server --watch db.json --port 4000

//load danh sách sản phẩm
async function loadProducts(){
    try{
        let res = await fetch(API_URL);//gửi request tới api để chờ lấy dữ liệu
        let products = await res.json();//chuyển đổi dữ liệu nhận được từ json thành js object

        let list = document.getElementById("product-list");
        list.innerHTML = products.map(p => `
            <div class="product">
                <img src="images/${p.image}" alt="${p.name}" width="150" height="100">
                <h3>${p.name}</h3>
                <p>${p.detail}</p>
                <p><strong>Giá: ${p.price} VND</strong></p>
                <button onclick="viewDetail(${p.id})">Xem chi tiết</button>
                <button onclick="addToCart(${p.id}, ${p.price}, '${p.name}')">Thêm vào giỏ</button>
            </div>
        `).join("");
    }
    catch(err){
        console.log("Lỗi khi load sản phẩm !",err);
    }
}

//chuyển sang trang chi tiết
function viewDetail(id){
    window.location.href = `product.html?id=${id}`;
}

function addToCart(id, price, name) {
    let cart = JSON.parse(localStorage.getItem("cart")) || []; 

    let item = cart.find(i => i.productId === id);
    if(item){
        item.quantity++;
    } else {
        cart.push({
            productId: id,
            name: name,       // lưu thêm để hiển thị nhanh
            price: price,     // lưu thêm để không phải fetch API lại
            quantity: 1
        });
    }

    localStorage.setItem("cart", JSON.stringify(cart));
    alert("Đã thêm vào giỏ hàng !");
}

loadProducts();