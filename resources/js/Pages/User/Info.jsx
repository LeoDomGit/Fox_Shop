import React, { useEffect, useState } from "react";

function Info() {
    const [user, setUser] = useState({ name: "", email: "" });

    useEffect(() => {
        try {
            const storedUser = localStorage.getItem("user");
            if (storedUser) {
                setUser(JSON.parse(storedUser)); // Chỉ parse nếu tồn tại giá trị hợp lệ
            }
        } catch (error) {
            console.error("Failed to parse user data:", error);
        }
    }, []);

return (
    <div>
        <h1>Welcome, {user.name}!</h1>
        <p>Email: {user.email}</p>
        <img
            src={`https://dashboard.codingfs.com${user.avatar}`}
            alt="User Avatar"
        />
        <a href="/api/logout">Đăng xuất</a>
    </div>
);

}

export default Info;
