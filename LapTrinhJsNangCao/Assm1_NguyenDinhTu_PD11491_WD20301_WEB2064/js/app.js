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
            </div>
        `).join("");
    }
    catch(err){
        console.log("Lỗi khi load sản phẩm !",err);
    }
}

//chuyển sang trang chi tiết
function viewDetail(id){
    window.location.href = `product_detail.html?id=${id}`;
}

loadProducts();