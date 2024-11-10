import React, { useState } from "react";
import axios from "axios";
import { usePage } from "@inertiajs/react";

const ResetPassword = () => {
    const [password, setPassword] = useState("");
    const [passwordConfirmation, setPasswordConfirmation] = useState("");
    const [message, setMessage] = useState("");
    const { token, email } = usePage().props;
    console.log("Token:", token);
    const handleResetPassword = async (e) => {
        e.preventDefault();
        try {
            const response = await axios.post("/api/resetPassword", {
                token,
                email,
                password,
                password_confirmation: passwordConfirmation,
            });
            setMessage(response.data.status);
        } catch (error) {
            setMessage(
                error.response.data.message ||
                    "Có lỗi xảy ra. Vui lòng thử lại."
            );
        }
    };

    return (
        <div>
            <h2>Đặt lại mật khẩu</h2>
            <form onSubmit={handleResetPassword}>
                <label>Mật khẩu mới:</label>
                <input
                    type="password"
                    value={password}
                    onChange={(e) => setPassword(e.target.value)}
                    required
                />
                <label>Nhập lại mật khẩu:</label>
                <input
                    type="password"
                    value={passwordConfirmation}
                    onChange={(e) => setPasswordConfirmation(e.target.value)}
                    required
                />
                <button type="submit">Đặt lại mật khẩu</button>
            </form>
            {message && <p>{message}</p>}
        </div>
    );
};

export default ResetPassword;
