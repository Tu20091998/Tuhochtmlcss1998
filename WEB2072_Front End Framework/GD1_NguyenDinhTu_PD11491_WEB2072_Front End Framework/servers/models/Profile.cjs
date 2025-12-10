// servers/models/Profile.js
const mongoose = require("mongoose");

const ProfileSchema = new mongoose.Schema({
    name: { type: String, required: true },
    title: String,
    email: String,
    phone: String,
    address: String,
    avatar: String,
    bio: String,
    social: { // Embedded Document cho Social
        github: String,
        facebook: String,
        youtube: String,
        gmail: String,
    },
  hardSkills: [String], // Mảng các chuỗi
  softSkills: [String], // Mảng các chuỗi
  imageVarriant: [String], // Mảng các chuỗi
});

module.exports = mongoose.model("Profile", ProfileSchema);
// Collection trong Mongo sẽ là 'profiles'