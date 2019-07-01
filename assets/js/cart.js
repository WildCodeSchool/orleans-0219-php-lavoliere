function onClickDecrement(event)
{
    event.preventDefault();
    fetch(this.href)
        .then(function (response) {
            return response.json();
        })
        .then(function (response) {
                const id_product = response.id;
                const spanQuantity = document.getElementById("quantity-selector-" + id_product);
                const spanTotal = document.getElementById("product-total-" + id_product);
                const ResultCart = document.getElementById("result-cart");
                spanQuantity.textContent = response.quantity;
                spanTotal.textContent = response.totalProduct.toFixed(2) + ' €';
                ResultCart.textContent = response.totalCart.toFixed(2) + ' € TTC';
        });
}

document.querySelectorAll('a.cart-decrement').forEach(function (link) {
    link.addEventListener('click', onClickDecrement)
});



function onClickIncrement(event)
{
    event.preventDefault();
    fetch(this.href)
        .then(function (response) {
            return response.json();
        })
        .then(function (response) {
                const id_product = response.id;
                const spanQuantity = document.getElementById("quantity-selector-" + id_product);
                const spanTotal = document.getElementById("product-total-" + id_product);
                const ResultCart = document.getElementById("result-cart");
                spanQuantity.textContent = response.quantity;
                spanTotal.textContent = response.totalProduct.toFixed(2) + ' €';
                ResultCart.textContent = response.totalCart.toFixed(2) + ' € TTC';
        });
}

document.querySelectorAll('a.cart-increment').forEach(function (link) {
    link.addEventListener('click', onClickIncrement)
});
