
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
            alert("Tổng = "+ ketqua);
            break;
        
        case '-': 
            ketqua = a - b;
            alert("Hiệu = "+ ketqua);
            break;

        case '*': 
            ketqua = a * b;
            alert("Tích = "+ ketqua);
            break;

        case '/': 
            ketqua = a / b;
            alert("Thương = "+ ketqua);
            break;
        
        default: alert(o + " Không phải là toán tử");
    }
    
};

