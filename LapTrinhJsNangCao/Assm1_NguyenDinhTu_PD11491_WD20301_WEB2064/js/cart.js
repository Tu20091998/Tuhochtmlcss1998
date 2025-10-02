//js/cart.js
//khai báo đường dẫn api
const API_URL = "http://localhost:4000/products";

async function loadCart(){
    //lấy dữ liệu từ local và chuyển đổi thành js
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    let tbody = document.getElementById("cart-items");
    let total = 0;

    tbody.innerHTML = "";

    //lặp và hiển thị giỏ hàng
    for(let item of cart){
        let subtotal = item.price * item.quantity;
        total += subtotal;

        tbody.innerHTML += `
            <tr>
                <td>${item.name}</td>
                <td>${item.price} VND</td>
                <td>
                    <button onclick="updateQuantity(${item.productId}, -1)">-</button>
                    ${item.quantity}
                    <button onclick="updateQuantity(${item.productId}, 1)">+</button>
                </td>
                <td>${subtotal} VND</td>
                <td><button onclick="removeItem(${item.productId})">Xóa</button></td>
            </tr>
        `;
    }
    document.getElementById("total").innerText = total;
}

//hàm cập nhật số lượng trong giỏ hàng
function updateQuantity(productId, change){
    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    //kiểm tra xem có sản phẩm trong giỏ hàng hay chưa?
    let item = cart.find(i => i.productId === productId);

    if(item){
        item.quantity += change;

        //nếu số lượng bằng 0 thì xoá sản phẩm khỏi giỏ
        if(item.quantity <= 0){
            cart = cart.filter(i => i.productId !== productId);
        }
    }
    //chuyển dữ liệu đưa lại vào local
    localStorage.setItem("cart", JSON.stringify(cart));

    loadCart(); //render lại;
}

//hàm xoá sản phẩm trong giỏ hàng
function removeItem(productId){
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    cart = cart.filter(i => i.productId !== productId);
    localStorage.setItem("cart", JSON.stringify(cart));
    loadCart();
}

loadCart();