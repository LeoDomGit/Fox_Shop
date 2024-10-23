import React, { useState } from "react";
import axios from "axios";

function Login() {
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");
    const [error, setError] = useState("");

    const handleLogin = async (e) => {
        e.preventDefault(); // Ngăn không cho trang bị load lại
        try {
            const response = await axios.post("/admin/users/login", {
                email,
                password,
            });

            if (response.status === 200) {
                // Lưu token vào localStorage
                const { token, user } = response.data;
                 localStorage.setItem("token", token);
                localStorage.setItem("user", JSON.stringify(user));
                alert("Đăng nhập thành công!");
                window.location.href = "/info";
            }
        } catch (err) {
            setError("Đăng nhập không thành công. Vui lòng kiểm tra lại!");
        }
    };

    return (
        <>
            <h2>Login</h2>
            <form onSubmit={handleLogin}>
                <input
                    type="email"
                    placeholder="Email"
                    value={email}
                    onChange={(e) => setEmail(e.target.value)}
                    className="mb-3 form-control"
                />{" "}
                <br />
                <input
                    type="password"
                    placeholder="Password"
                    value={password}
                    onChange={(e) => setPassword(e.target.value)}
                    className="mb-3 form-control"
                />{" "}
                <br />
                <button type="submit" className="btn btn-primary">
                    Login
                </button>
            </form>
            {error && <p style={{ color: "red" }}>{error}</p>}
        </>
    );
}

export default Login;
