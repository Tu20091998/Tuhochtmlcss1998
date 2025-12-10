//----------------------------------------------------
//Phần gọi db của mongoDB
const express = require('express');
const cors = require('cors'); 
const connectDB = require("./mongo.cjs");

// Khai báo Express app
const app = express(); 

// Định nghĩa cấu hình CORS chi tiết
const corsOptions = {
    // Cho phép gọi API từ cổng mặc định của Vue/Vite
    origin: ['http://localhost:5173', 'http://127.0.0.1:5173'], 
    methods: "GET,HEAD,PUT,PATCH,POST,DELETE",
    credentials: true, // Cho phép gửi cookies, headers ủy quyền, v.v.
    optionsSuccessStatus: 204
};

app.use(cors(corsOptions)); //
app.use(express.json());// dòng này để nhận body json bên các trang trả về backend

// Gọi hàm kết nối database
connectDB();

//node servers/crudServer.cjs

// Khởi chạy Server trên cổng 3005
const PORT = 3005; // Đảm bảo cổng là 3005 để khớp với Frontend Vue

// Thay thế đoạn code khởi chạy server cũ bằng đoạn này:
(async () => {
    try {
        await connectDB(); // Chờ kết nối DB hoàn tất

        app.listen(PORT, () => {
            console.log(`✅ Server CRUD MongoDB đang chạy tại http://localhost:${PORT}`);
        });
    } catch (error) {
        console.error("❌ Lỗi Khởi động Server:", error);
    }
})();

// servers/server.cjs (Phần Routes)

// Import Models
const Article = require("./models/Article.cjs");
const Project = require("./models/Project.cjs");
const Education = require("./models/Education.cjs");
const Experience = require("./models/Experience.cjs");
const User = require("./models/User.cjs");
const Profile = require("./models/Profile.cjs");
const Message = require("./models/Message.cjs");


// Route: /articles
app.get("/articles", async (req, res) => {
    try {
        const data = await Article.find();
        res.json(data);
    } catch (error) { res.status(500).json({ message: "Lỗi Server", error }); }
});

// CREATE (POST) - Thêm mới Bài viết
app.post("/articles", async (req, res) => {
    try {
        const newArticle = await Article.create(req.body);
        res.status(201).json(newArticle);
    } catch (error) {
        res.status(400).json({ message: "Lỗi khi tạo Bài viết mới", details: error.message });
    }
});

// UPDATE (PUT) - Cập nhật theo ID
app.put("/articles/:id", async (req, res) => {
    try {
        const updatedArticle = await Article.findByIdAndUpdate(
            req.params.id, // ID từ URL
            req.body,
            { new: true, runValidators: true }
        );
        if (!updatedArticle) {
            return res.status(404).json({ message: `Không tìm thấy Bài viết ID: ${req.params.id}` });
        }
        res.json(updatedArticle);
    } catch (error) {
        res.status(400).json({ message: "Lỗi khi cập nhật Bài viết", details: error.message });
    }
});

//xoá bài viết
app.delete("/articles/:id", async (req, res) => {
    try {
        const deletedArticle = await Article.findByIdAndDelete(req.params.id);

        if (!deletedArticle) {
            return res.status(404).json({ 
                message: `Không tìm thấy bài viết ID: ${req.params.id}` 
            });
        }

        res.json({ 
            message: `Đã xóa bài viết ID: ${req.params.id} thành công!`,
            deleted: deletedArticle
        });

    } catch (error) {
        res.status(500).json({ 
            message: "Lỗi khi xóa bài viết",
            details: error.message 
        });
    }
});



// Route: /projects
app.get("/projects", async (req, res) => {
    try {
        const data = await Project.find();
        res.json(data);
    } catch (error) { res.status(500).json({ message: "Lỗi Server", error }); }
});

// CREATE (POST) - Thêm mới Dự án
app.post("/projects", async (req, res) => {
    try {
        const newProject = await Project.create(req.body);
        res.status(201).json(newProject);
    } catch (error) {
        // Lỗi 400 thường xảy ra nếu thiếu trường required (name) hoặc sai kiểu dữ liệu (members, startDate, endDate)
        res.status(400).json({ message: "Lỗi khi tạo Dự án mới", details: error.message });
    }
});

// UPDATE (PUT) - Cập nhật Dự án theo ID
app.put("/projects/:id", async (req, res) => {
    try {
        const updatedProject = await Project.findByIdAndUpdate(
            req.params.id, // ID từ URL
            req.body,
            { new: true, runValidators: true } // new: true trả về document đã cập nhật
        );
        if (!updatedProject) {
            return res.status(404).json({ message: `Không tìm thấy Dự án ID: ${req.params.id}` });
        }
        res.json(updatedProject);
    } catch (error) {
        res.status(400).json({ message: "Lỗi khi cập nhật Dự án", details: error.message });
    }
});

// DELETE (DELETE) - Xóa Dự án theo ID
app.delete("/projects/:id", async (req, res) => {
    try {
        const deletedProject = await Project.findByIdAndDelete(req.params.id);
        if (!deletedProject) {
            return res.status(404).json({ message: `Không tìm thấy Dự án ID: ${req.params.id}` });
        }
        res.json({ message: `Dự án ID: ${req.params.id} đã được xóa thành công!` });
    } catch (error) {
        res.status(500).json({ message: "Lỗi khi xóa Dự án", details: error.message });
    }
});



// Route: /education
app.get("/education", async (req, res) => {
    try {
        const data = await Education.find();
        res.json(data);
    } catch (error) { res.status(500).json({ message: "Lỗi Server", error }); }
});

// CREATE (POST) - Thêm mới Học vấn
app.post("/education", async (req, res) => {
    try {
        const newEducation = await Education.create(req.body);
        res.status(201).json(newEducation);
    } catch (error) {
        // Lỗi 400 thường xảy ra nếu thiếu trường required (institution)
        res.status(400).json({ message: "Lỗi khi tạo mục Học vấn mới", details: error.message });
    }
});

// UPDATE (PUT) - Cập nhật Học vấn theo ID
app.put("/education/:id", async (req, res) => {
    try {
        const updatedEducation = await Education.findByIdAndUpdate(
            req.params.id, // ID từ URL
            req.body,
            { new: true, runValidators: true } // new: true trả về document đã cập nhật
        );
        if (!updatedEducation) {
            return res.status(404).json({ message: `Không tìm thấy mục Học vấn ID: ${req.params.id}` });
        }
        res.json(updatedEducation);
    } catch (error) {
        res.status(400).json({ message: "Lỗi khi cập nhật mục Học vấn", details: error.message });
    }
});

// DELETE (DELETE) - Xóa Học vấn theo ID
app.delete("/education/:id", async (req, res) => {
    try {
        const deletedEducation = await Education.findByIdAndDelete(req.params.id);
        if (!deletedEducation) {
            return res.status(404).json({ message: `Không tìm thấy mục Học vấn ID: ${req.params.id}` });
        }
        res.json({ message: `Mục Học vấn ID: ${req.params.id} đã được xóa thành công!` });
    } catch (error) {
        res.status(500).json({ message: "Lỗi khi xóa mục Học vấn", details: error.message });
    }
});


// Route: /experience
app.get("/experience", async (req, res) => {
    try {
        const data = await Experience.find();
        res.json(data);
    } catch (error) { res.status(500).json({ message: "Lỗi Server", error }); }
});

// CREATE (POST) - Thêm mới Kinh nghiệm
app.post("/experience", async (req, res) => {
    try {
        const newExperience = await Experience.create(req.body);
        res.status(201).json(newExperience);
    } catch (error) {
        // Lỗi 400 thường xảy ra nếu thiếu trường required (title)
        res.status(400).json({ message: "Lỗi khi tạo mục Kinh nghiệm mới", details: error.message });
    }
});

// UPDATE (PUT) - Cập nhật Kinh nghiệm theo ID
app.put("/experience/:id", async (req, res) => {
    try {

        const updatedExperience = await Experience.findByIdAndUpdate(
            req.params.id, // ID từ URL
            req.body,
            { new: true, runValidators: true } // new: true trả về document đã cập nhật
        );
        if (!updatedExperience) {
            return res.status(404).json({ message: `Không tìm thấy mục Kinh nghiệm ID: ${req.params.id}` });
        }
        res.json(updatedExperience);
    } catch (error) {
        res.status(400).json({ message: "Lỗi khi cập nhật mục Kinh nghiệm", details: error.message });
    }
});

// DELETE (DELETE) - Xóa Kinh nghiệm theo ID
app.delete("/experience/:id", async (req, res) => {
    try {
        const deletedExperience = await Experience.findByIdAndDelete(req.params.id);
        if (!deletedExperience) {
            return res.status(404).json({ message: `Không tìm thấy mục Kinh nghiệm ID: ${req.params.id}` });
        }
        res.json({ message: `Mục Kinh nghiệm ID: ${req.params.id} đã được xóa thành công!` });
    } catch (error) {
        res.status(500).json({ message: "Lỗi khi xóa mục Kinh nghiệm", details: error.message });
    }
});


// Route: /users (Hỗ trợ lọc bằng tham số truy vấn)
app.get("/users", async (req, res) => {
    try {
        let filter = {};
        
        //  Kiểm tra xem có tham số 'username' trong URL không
        if (req.query.username) {
            // Nếu có, tạo bộ lọc để tìm chính xác username đó
            filter = { username: req.query.username };
        }
        
        //  Thực hiện tìm kiếm với bộ lọc (nếu có)
        const data = await User.find(filter).select('username role password'); 
        
        res.json(data);
    } catch (error) { 
        res.status(500).json({ message: "Lỗi Server", error }); 
    }
});


// READ (GET) - Lấy dữ liệu cá nhân duy nhất
app.get("/personal", async (req, res) => {
    try {
        // FindOne sẽ lấy tài liệu đầu tiên (hoặc duy nhất)
        const data = await Profile.findOne({}); 
        if (!data) {
            return res.status(404).json({ message: "Không tìm thấy dữ liệu cá nhân" });
        }
        res.json(data);
    } catch (error) { 
        res.status(500).json({ message: "Lỗi Server", error }); 
    }
});

// UPDATE (PUT) - Cập nhật dữ liệu cá nhân duy nhất
app.put("/personal", async (req, res) => {
    // Lấy ID (nếu có) hoặc mặc định tìm document duy nhất
    const dataToUpdate = req.body;

    // Loại bỏ _id khỏi body nếu nó tồn tại (Mongo không cho cập nhật _id)
    delete dataToUpdate._id; 
    
    try {
        // FindOneAndUpdate với bộ lọc rỗng {} sẽ tìm thấy và cập nhật tài liệu đầu tiên (duy nhất)
        const updatedProfile = await Profile.findOneAndUpdate(
            {}, 
            dataToUpdate,
            { new: true, runValidators: true, upsert: false } // new: true trả về bản cập nhật
        );

        if (!updatedProfile) {
            // Nếu không tìm thấy, có thể tạo mới (nếu bạn muốn)
            return res.status(404).json({ message: "Không tìm thấy tài liệu Profile để cập nhật." });
        }
        
        res.json(updatedProfile);
    } catch (error) {
        console.error('Lỗi API PUT /personal:', error);
        res.status(400).json({ message: "Lỗi khi cập nhật thông tin cá nhân", details: error.message });
    }
});


// READ (GET) - Lấy danh sách tin nhắn
app.get("/messages", async (req, res) => {
    try {
        const data = await Message.find().sort({ timestamp: -1 }); // Sắp xếp theo thời gian mới nhất
        res.json(data);
    } catch (error) { 
        res.status(500).json({ message: "Lỗi Server", error }); 
    }
});

// CREATE (POST) - Gửi tin nhắn mới (Dùng cho Frontend User)
app.post("/messages", async (req, res) => {
    try {
        const newMessage = await Message.create(req.body);
        res.status(201).json(newMessage);
    } catch (error) {
        res.status(400).json({ message: "Lỗi khi gửi tin nhắn", details: error.message });
    }
});



