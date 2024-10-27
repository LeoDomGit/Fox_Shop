import React, { useEffect, useState } from "react";
import Layout from "../../components/Layout";
import axios from "axios";
import { Form } from "react-bootstrap";
function Edit({ category }) {
    const [name, setName] = useState("");
    const [position, setPosition] = useState("");
    const [fileImg, setFileImg] = useState([]);
    const handleSubmit = (e) => {
        e.preventDefault();
        
        const formData = new FormData() ;
        formData.append("name", name) ;
        formData.append("position", position) ;
        if (fileImg.length > 0) {
            formData.append("images", ...fileImg);
        }
        console.log(...formData);
        
        axios
            .post("/admin/categories/imgaes/" + category.id, formData)
            .then((res) => {
                if (res.data.check === true) {
                    alert("Cap nhat thanh cong");
                }
            });
    };

    useEffect(() => {
        setName(category?.name);
        setPosition(category?.position);
        setFileImg(category?.images);
    }, [category]);
    return (
        <Layout>
            <div>
                <div className="container">
                    <h2>Chỉnh sửa danh mục</h2>
                 
                    <form
                        onSubmit={handleSubmit}
                        enctype="multipart/form-data"
                        method="POST"
                    >
                        <div className="form-group">
                            <label htmlFor="name">Tên danh mục</label>
                            <input
                                type="text"
                                className="form-control"
                                value={name}
                                name="name"
                                placeholder="Tên danh mục"
                                onChange={(e) => setName(e.target.value)}
                            />
                        </div>
                        <div className="form-group">
                            <label htmlFor="name">Tên danh mục</label>
                            <input
                                type="text"
                                className="form-control"
                                value={position}
                                name="name"
                                onChange={(e) => setPosition(e.target.value)}
                                placeholder="Tên danh mục"
                            />
                        </div>
                        <div>
                            <label htmlFor="">Hình Ảnh</label>
                            <img src={fileImg} alt="aaaaaa" />
                            <input
                                type="file"
                                accept="image/*"
                                onChange={(e) => setFileImg(e.target.files)}
                                name="images"
                                id=""
                            />
                        </div>

                        <div className="form-group">
                            <button
                                type="submit"
                                // onClick={handleSubmit}
                                className="btn btn-primary"
                            >
                                Lưu danh mục
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </Layout>
    );
}

export default Edit;
