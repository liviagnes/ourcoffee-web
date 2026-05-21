// Ambil cart dari localStorage
function getCart(){ return JSON.parse(localStorage.getItem("cart"))||[]; }
function saveCart(cart){ localStorage.setItem("cart", JSON.stringify(cart)); }

// Toast popup
function showToast(msg){
    const toast = document.getElementById("toast");
    toast.innerText = msg;
    toast.classList.add("show");
    setTimeout(()=>toast.classList.remove("show"), 2500);
}

// Update badge keranjang
function updateCartBadge(){
    const total = getCart().reduce((sum,i)=>sum+i.qty,0);
    const badge = document.getElementById("cart-count");
    if(badge) badge.innerText = total;
}

// Render kontrol tombol menu (menu.php)
function renderControl(id){
    const cart = getCart();
    const item = cart.find(i=>i.id===id);
    const ctrl = document.getElementById("ctrl-"+id);
    if(!ctrl) return;

    if(item){
        ctrl.innerHTML = `
            <button onclick="changeQty(${id},-1)">−</button>
            <span class="qty">${item.qty}</span>
            <button onclick="changeQty(${id},1)">+</button>
        `;
    }else{
        ctrl.innerHTML = `<button class="add-only" onclick="addItem(${id},'${item?.name}','${item?.price}','${item?.image}')">+</button>`;
    }
}

// Tambah item
function addItem(id,name,price,image){
    let cart = getCart();
    let item = cart.find(i=>i.id===id);
    if(item){
        item.qty++;
        showToast(`${item.qty}x ${name} sudah di keranjang`);
    } else {
        cart.push({id,name,price,image,qty:1});
        showToast(`1x ${name} ditambahkan ke keranjang`);
    }
    saveCart(cart);
    renderControl(id);
    updateCartBadge();
}

// Ubah qty
function changeQty(id,delta){
    let cart = getCart();
    let item = cart.find(i=>i.id===id);
    if(!item) return;

    item.qty += delta;
    if(item.qty<=0){
        cart = cart.filter(i=>i.id!==id);
    }
    saveCart(cart);
    renderControl(id);
    updateCartBadge();
}

// === ORDER PAGE FUNCTIONS ===
function renderOrder(){
    const orderList = document.getElementById("order-list");
    const totalEl = document.getElementById("order-total");
    const emptyMsg = document.getElementById("empty-msg");
    const cart = getCart();
    if(!orderList || !totalEl || !emptyMsg) return;

    orderList.innerHTML = "";
    let total = 0;
    if(cart.length===0){
        emptyMsg.style.display="block";
        totalEl.innerText="0";
        return;
    }
    emptyMsg.style.display="none";

    cart.forEach(item=>{
        const itemTotal = item.price*item.qty;
        total += itemTotal;

        const div = document.createElement("div");
        div.className = "order-item";
        div.innerHTML = `
            <img src="${item.image}" alt="${item.name}">
            <div class="order-info">
                <h3>${item.name}</h3>
                <p>Rp ${item.price.toLocaleString()}</p>
                <div class="qty-control">
                    <button onclick="changeQtyOrder(${item.id},-1)">−</button>
                    <span class="qty-display">${item.qty}</span>
                    <button onclick="changeQtyOrder(${item.id},1)">+</button>
                    <button class="remove-btn" onclick="removeItemOrder(${item.id})">Remove</button>
                </div>
            </div>
            <div class="order-price">Subtotal: Rp ${itemTotal.toLocaleString()}</div>
        `;
        orderList.appendChild(div);
    });
    totalEl.innerText = total.toLocaleString();
}

function changeQtyOrder(id, delta){
    let cart = getCart();
    const item = cart.find(i=>i.id===id);
    if(!item) return;
    item.qty += delta;
    if(item.qty<=0){
        cart = cart.filter(i=>i.id!==id);
    }
    saveCart(cart);
    renderOrder();
    updateCartBadge();
}

function removeItemOrder(id){
    let cart = getCart().filter(i=>i.id!==id);
    saveCart(cart);
    renderOrder();
    updateCartBadge();
}

// Saat load halaman
window.onload = ()=>{
    updateCartBadge();
    if(document.getElementById("order-list")) renderOrder();
};
