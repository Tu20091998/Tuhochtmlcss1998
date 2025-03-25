function KhachSan(ten,soPhong,diaChi,soKhach){
    this.ten = ten;
    this.soPhong = soPhong;
    this.diaChi = diaChi;
    this.soKhach = function(){
        return this.soPhong * 2;
    }
}

//tạo ra mảng chứa 6 khách sạn
var danhSachKs = [
    new KhachSan("Tuấn",12,"30 lôi điểu"),
    new KhachSan("Tú",14,"30 lôi quang"),
    new KhachSan("Tường",16,"30 lôi thần"),
    new KhachSan("Tướng",18,"30 đinh lệ"),
    new KhachSan("Tún",20,"30 doãn uẩn"),
    new KhachSan("Tính",10,"30 lôi điểu"),
];

//dùng lặp for để in ra 6 khách sạn
for(let i = 0;i < danhSachKs.length; i++){
    console.log('<br> Khách sạn thứ '+ (i+1)+ " Tên : "+ danhSachKs[i].ten + " Số phòng: "+ danhSachKs[i].soPhong+ "Địa chỉ: "+ danhSachKs[i].diaChi+ "Số khách: "+ danhSachKs[i].soKhach());
}