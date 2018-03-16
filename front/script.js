//Server URL
var url = "http://localhost/fundacja/";

//CountUP
var am, tmp = 0, kStart = 0, kStop = 0, czas = 1, amount;

var options = {
    useEasing: true,
    useGrouping: true,
    separator: ' ',
    decimal: ',',
};

function pobierz()
{
	$.getJSON(url + "index.php/amount", function(json) {
		am = json.amount;
	});
    amount = parseFloat(am) / 100;
}

//Photos
var img = "null", tempImg = "";

function pobierzZdjecie(){
	$.getJSON(url + "index.php/photos/getphoto", function(json) {
		img = json.img;
	});
}

window.onload = function() {
	pobierz();
	pobierzZdjecie();
};

setInterval(function(){

	pobierz();
	pobierzZdjecie();
	
	setTimeout(function(){
		//AMOUNT
		if(tmp == amount)
		{
			//console.log("Brak zmiany kwoty!");
		} else {
            //console.log("Zmiana kwoty!");
			kStart = tmp;
			kStop = amount;

			tmp = amount;
			
			var diff = parseFloat(kStop) - parseFloat(kStart);
            diff = Math.abs(diff);

			if (diff > 10000){
				czas = 10;
			} else if (diff > 5000){
				czas = 50;
			} else {
				czas = 3;
			}

			//Magic
			var demo = new CountUp("licznik", kStart, kStop, 0, czas, options);
			if (!demo.error) {
			  demo.start();
			} else {
			  console.error(demo.error);
			}
		}
		//PHOTOS
		
		if(tempImg == img){
			//console.log("Brak zmiany zdjecia!");
		} else{
            //console.log("Zmiana zdjecia!");
            //console.log(img);
			tempImg = img;
			
			img = "images/" + img + ".jpg";
			var style = "background-image:url(" + img + ");";

			document.getElementById("body").style = style;
		}

	}, 200);


}, 700);

