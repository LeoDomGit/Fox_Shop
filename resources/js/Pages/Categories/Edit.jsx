// import React, { useEffect, useState } from "react";
// import { useParams, useNavigate } from "react-router-dom";
// import Layout from "../../components/Layout";
// import axios from "axios";
// import { Notyf } from "notyf";
// import Swal from "sweetalert2";
// import "notyf/notyf.min.css";

// function Edit({ dataId, category }) {
//     const [id, setId] = useState(dataId);
//     const [categoryData, setCategoryData] = useState(category);
//     const [images, setImages] = useState([]);
//     const notyf = new Notyf({
//         duration: 2000,
//         position: { x: "right", y: "top" },
//         types: [
//             {
//                 type: "success",
//                 background: "green",
//                 color: "white",
//                 className: "notyf-success",
//             },

//             {
//                 type: "error",
//                 background: "indianred",
//                 className: "notyf-error",
//             },
//         ],
//     });

//     // Cập nhật state khi người dùng nhập dữ liệu
//     const handleInputChange = (e) => {
//         const { name, value } = e.target;
//         setCategoryData((prev) => ({ ...prev, [name]: value }));
//     };
//     useEffect(() => {
//         console.log("prosssduct", images); // In ra product mỗi khi nó thay đổi
//     }, [images[0]]);
//     const handleUpdate = () => {
//         const updateData = {
//             ...categoryData,
//             images: images,
//         }
//         axios
//             .put("/admin/categories/" + dataId, updateData, {
//                 headers: {
//                     "Content-Type": "multipart/form-data",
//                 },
//             })
//             .then((res) => {
//                 if (res.data.check === true) {
//                     notyf.success("Cập nhật thành công!");
//                 } else {
//                     notyf.error(res.data.msg);
//                 }
//             })
//             .catch((error) => {
//                 console.error(error);
//                 notyf.error("Có lỗi xảy ra khi cập nhật.");
//             });
//     };
//     const handleDelete = () => {
//         Swal.fire({
//             icon: "question",
//             text: "Xóa danh mục này?",
//             showDenyButton: true,
//             confirmButtonText: "Đúng",
//             denyButtonText: "Không",
//         }).then((result) => {
//             if (result.isConfirmed) {
//                 axios
//                     .delete("/admin/categories/${id}")
//                     .then((res) => {
//                         if (res.data.check) {
//                             notyf.success("Đã xóa thành công");
//                             navigate("/admin/categories");
//                         } else {
//                             notyf.error(
//                                 res.data.msg || "Xóa không thành công."
//                             );
//                         }
//                     })
//                     .catch((error) => {
//                         console.error(error);
//                         notyf.error("Có lỗi xảy ra khi xóa.");
//                     });
//             }
//         });
//     };

//     return (
//         <Layout>
//             <div className="container w-50">
//                 <h2>Chỉnh sửa danh mục</h2>
//                 <div>
//                     <label>Tên danh mục:</label>
//                     <input
//                         type="text"
//                         name="name"
//                         value={categoryData.name || ""}
//                         onChange={handleInputChange}
//                         required
//                     />
//                 </div>
//                 <div>
//                     <label>Vị trí:</label>
//                     <input
//                         type="number"
//                         name="position"
//                         value={categoryData.position || ""}
//                         onChange={handleInputChange}
//                         required
//                     />
//                 </div>
//                 <div>
//                     <label>Hình ảnh:</label>
//                     <img
//                         src={categoryData.images}
//                         className="img-fluid"
//                         alt="Hình danh mục"
//                     />
//                     <label htmlFor="">Hình ảnh</label>
//                     <input
//                         type="file"
//                         className="form-control"
//                         multiple
//                         onChange={(e) => setImages(e.target.files[0])}
//                     />
//                     {images.length > 0 && (
//                         <div>
//                             <>Hình ảnh đã chọn:</>
//                             <div className="d-flex">
//                                 {images.map((image, index) => (
//                                     <img
//                                         key={index}
//                                         src={URL.createObjectURL(image)}
//                                         alt="preview"
//                                         width="100"
//                                         height="100"
//                                         className="m-2"
//                                     />
//                                 ))}
//                             </div>
//                         </div>
//                     )}
//                 </div>
//                 <div className="row">
//                     <div className="col">
//                         <button type="button" onClick={handleUpdate}>
//                             Cập nhật
//                         </button>
//                     </div>
//                     <div className="col">
//                         <button type="button" onClick={handleDelete}>
//                             Xóa
//                         </button>
//                     </div>
//                 </div>
//             </div>
//         </Layout>
//     );
// }

// export default Edit;