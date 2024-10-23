import React, { useState } from "react";
import axios from "axios";
import { useParams } from "react-router-dom";

const ResetPassword = () => {
    const [password, setPassword] = useState("");
    const [passwordConfirmation, setPasswordConfirmation] = useState("");
    const [message, setMessage] = useState("");
    const { token } = useParams(); // Lấy token từ URL

    const handleResetPassword = async (e) => {
        e.preventDefault();

        try {
            const response = await axios.post("/password/reset", {
                token,
                password,
                password_confirmation: passwordConfirmation,
            });
            setMessage(response.data.status);
        } catch (error) {
            setMessage(
                error.response.data.email || "Có lỗi xảy ra. Vui lòng thử lại."
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
