
var a = null;
var b = null;
var o = null;
var toan_hang = function(x){
    if(a==null){
        a=x;
    }
    else{
        b=x;
    }
};

var toan_tu = function(x){
    if(a != null){
        o = x;
    }
};

var lam_lai = function(){
    a = null;
    b = null;
    o = null;
};

var thuc_hien = function(){
    var ketqua;
    switch(o){
        case '+': 
            ketqua = a + b;
            console.log("Tổng = "+ ketqua);
            break;
        
        case '-': 
            ketqua = a - b;
            console.log("Hiệu = "+ ketqua);
            break;

        case '*': 
            ketqua = a * b;
            console.log("Tích = "+ ketqua);
            break;

        case '/': 
            ketqua = a / b;
            console.log("Thương = "+ ketqua);
            break;
        
        default: console.log(o + " Không phải là toán tử");
    }
    
};

