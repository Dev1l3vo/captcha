var btn = document.getElementById('captchaBtn');
var req = new XMLHttpRequest();
var imgObj;


if(btn){
   btn.addEventListener('click',(event)=>{
        req.open('GET','http://localhost/captcha/index.php');
        req.send();
   }) 
}

req.onreadystatechange = () =>{
    if (req.readyState === 4){
        console.log(req.responseText);
        var resp = JSON.parse(req.responseText);
        imgObj = document.getElementById("imageCap");
        if(imgObj==null){
            imgObj = document.createElement('img');
            imgObj.setAttribute('id','imageCap');
            document.body.appendChild(imgObj);
        }
        imgObj.src = "data:image/png;base64"+", "+resp.photoEncode;
        
    }
}