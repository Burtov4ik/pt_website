var count = 0;
document.getElementById("myButton").onclick = function() {
    count ++;
    if (count % 2 == 0) {
        document.getElementById("demo").innerHTML = "";
    } else {
        var img = document.createElement("img");
        img.src = "https://playmaker24.ru/wp-content/uploads/2020/11/image_news-25-1.jpeg";
        document.getElementById("demo").appendChild(img);
    }
}