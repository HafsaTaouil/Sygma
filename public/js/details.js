var totalPrice = document.getElementById("totalPrice");
var pricesContainer = document.getElementsByClassName("price");

var prices = [];
Array.from(pricesContainer).forEach((tdPrice)=>{
    let price = parseFloat(tdPrice.textContent.trim());
    prices.push(price);
});

var total = 0;

prices.forEach((price)=>{
    total+=price;
});

Number.isNaN(total)  ? totalPrice.textContent=0 : totalPrice.textContent=total;

console.log(totalPrice.textContent);

