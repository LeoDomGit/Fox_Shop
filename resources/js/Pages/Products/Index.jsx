// eslint-disable
import axios from "axios";
import React, { useEffect, useState } from "react";
import Layout from "../../components/Layout";
import { Notyf } from "notyf";
import { Box, Switch, Typography } from "@mui/material";
import "notyf/notyf.min.css";
import CKEditor from "../../components/CKEditor";
import { DataGrid, GridToolbar } from "@mui/x-data-grid";
import OutlinedInput from "@mui/material/OutlinedInput";
import { useTheme } from "@mui/material/styles";
import { MenuItem, Select, InputLabel, FormControl } from "@mui/material";
function Index({ dataproducts, databrands, datacategories }) {
    const [create, setCreate] = useState(false);
    const [categories, setCategories] = useState(datacategories);
    const [brands, setBrands] = useState(databrands);
    const [products, setProducts] = useState(dataproducts);
    const handleCellEditStop = (id, field, value) => {
        axios
            .put(
                `/admin/products/` + id,
                {
                    [field]: value,
                },
                {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem(
                            "token"
                        )}`,
                        Accept: "application/json",
                    },
                }
            )
            .then((res) => {
                if (res.data.check == true) {
                    notyf.open({
                        type: "success",
                        message: "Product is updated successfully",
                    });
                    setProducts(res.data.data);
                    console.log(res.data.data);
                } else if (res.data.check == false) {
                    notyf.open({
                        type: "error",
                        message: res.data.msg,
                    });
                }
            })
            .catch((error) => {
                console.error("Error updating product:", error);
                notyf.open({
                    type: "error",
                    message: "An error occurred while updating the product.",
                });
            });
    };
    const ITEM_HEIGHT = 15;
    const ITEM_PADDING_TOP = 0;
    const notyf = new Notyf({
        duration: 1000,
        position: {
            x: "right",
            y: "top",
        },
        types: [
            {
                type: "warning",
                background: "orange",
                icon: {
                    className: "material-icons",
                    tagName: "i",
                    text: "warning",
                },
            },
            {
                type: "error",
                background: "indianred",
                duration: 2000,
                dismissible: true,
            },
            {
                type: "success",
                background: "green",
                color: "white",
                duration: 2000,
                dismissible: true,
            },
            {
                type: "info",
                background: "#24b3f0",
                color: "white",
                duration: 1500,
                dismissible: false,
                icon: '<i class="bi bi-bag-check"></i>',
            },
        ],
    });
    const formatCreatedAt = (dateString) => {
        const date = new Date(dateString);
        return date.toLocaleString();
    };
    const formatPrice = (params) => {
        return new Intl.NumberFormat("en-US").format(params);
    };
    const formatDiscount = (params) => {
        return new Intl.NumberFormat("en-US").format(params);
    };

    function switchProduct(params, value) {
        axios
            .put(
                "/admin/products/switch/" + params.id,
                { status: value },
                {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem(
                            "token"
                        )}`,
                        Accept: "application/json",
                    },
                }
            )
            .then((res) => {
                if (res.data.check == false) {
                    if (res.data.msg) {
                        notyf.open({
                            type: "error",
                            message: res.data.msg,
                        });
                    }
                } else if (res.data.check == true) {
                    notyf.open({
                        type: "success",
                        message: "Switch successfully",
                    });
                    setProducts(res.data.data);
                }
            });
    }
    const columns = [
        { field: "id", headerName: "#", width: 100 },
        {
            field: "name",
            headerName: "Tên sản phẩm",
            width: 200,
            editable: true,
        },
        { field: "slug", headerName: "Slug", width: 200, editable: false },
        {
            field: "price",
            headerName: "Price",
            width: 100,
            editable: true,
            valueFormatter: formatPrice,
        },
        {
            field: "discount",
            headerName: "Discount",
            width: 100,
            editable: true,
            valueFormatter: formatDiscount,
        },
        { field: "color", headerName: "Màu sắch", width: 200, editable: true },
        {
            field: "brandName",
            headerName: "Thương hiệu",
            sortable: false,
            width: 200,
            renderCell: (params) => params.row.brands.name,
        },
        // {
        //     field:"cateName",
        //     headerName: "Loại sản phẩm",
        //     sortable: false,
        //     width: 200,
        //     renderCell: (params) => (params.row.categories.name),
        // },
        {
            field: "created_at",
            headerName: "Created at",
            width: 200,
            valueGetter: (params) => formatCreatedAt(params),
        },
        {
            field: "status",
            headerName: "Status",
            width: 70,
            renderCell: (params) => (
                <Switch
                    checked={params.value == 1}
                    onChange={(e) =>
                        switchProduct(params, e.target.checked ? 1 : 0)
                    }
                    inputProps={{ "aria-label": "controlled" }}
                />
            ),
        },
        {
            field: "editLink",
            headerName: "Edit",
            renderCell: (params) => {
                const productId = params.row.id;
                return (
                    <a
                        className="btn btn-sm btn-warning"
                        href={`/admin/products/${productId}`}
                    >
                        Edit
                    </a>
                );
            },
        },
    ];
    const [name, setName] = useState("");
    const [price, setPrice] = useState(0);
    const [discount, setDiscount] = useState(0);
    const [color, setColor] = useState("");
    const [idCate, setIdCate] = useState(0);
    const [idBrand, setIdBrand] = useState(0);
    const [inStock, setInstock] = useState(0);
    const [content, setContent] = useState("");
    const [cate, setCate] = useState([]);
    const [selectedFiles, setSelectedFiles] = useState([]);
    const theme = useTheme();
    const [filePreviews, setFilePreviews] = useState([]);
    const ChangeCreate = () => {
        if (create == false) {
            setCreate(true);
        } else {
            setCreate(false);
        }
    };
    const resetCreate = () => {
        setName("");
        setColor("");
        setPrice(0);
        setDiscount(0);
        setIdCate(0);
        setIdBrand(0);
        setContent("");
        setSelectedFiles([]);
        setFilePreviews([]);
        setCreate(false);
    };
    const SubmitProduct = () => {
        if (name == "") {
            notyf.open({
                type: "error",
                message: "Vui lòng nhập tên sản phẩm",
            });
        } else if (color == "") {
            notyf.open({
                type: "error",
                message: "Vui lòng nhập màu sắc cho sản phẩm",
            });
        } else if (price == 0) {
            notyf.open({
                type: "error",
                message: "Vui lòng nhập giá sản phẩm",
            });
        } else if (categories.length == 0) {
            notyf.open({
                type: "error",
                message: "Vui lòng chọn danh mục cho sản phẩm",
            });
        } else if (idBrand == 0) {
            notyf.open({
                type: "error",
                message: "Vui lòng chọn thương hiệu sản phẩm",
            });
        } else if (content == "") {
            notyf.open({
                type: "error",
                message: "Vui lòng nhập mô tả sản phẩm",
            });
        } else if (selectedFiles.length == 0) {
            notyf.open({
                type: "error",
                message: "Vui lòng up hình ảnh sản phẩm",
            });
        } else {
            var formData = new FormData();
            formData.append("name", name);
            formData.append("color", color);
            formData.append("price", price);
            formData.append("discount", discount);
            formData.append("idCate", idCate);
            formData.append("idBrand", idBrand);
            formData.append("content", content);
            formData.append("in_stock", inStock);
            selectedFiles.forEach((file) => {
                formData.append("files[]", file);
            });
            cate.forEach((el) => {
                formData.append("categories[]", el);
            });
        }
        axios
            .post("/admin/products", formData, {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem("token")}`,
                    Accept: "application/json",
                },
            })
            .then((res) => {
                if (res.data.check == true) {
                    setProducts(res.data.data);
                    resetCreate();
                }
            });
    };

    const handleRemoveImage = (index) => {
        const updatedFiles = [...selectedFiles];
        updatedFiles.splice(index, 1);
        setSelectedFiles(updatedFiles);

        const updatedPreviews = [...filePreviews];
        updatedPreviews.splice(index, 1);
        setFilePreviews(updatedPreviews);
    };
    const handleChange = (event) => {
        const {
            target: { value },
        } = event;
        setCate(
            // On autofill we get a stringified value.
            typeof value === "string" ? value.split(",") : value
        );
    };
    const handleImageChange = (e) => {
        const files = Array.from(e.target.files);
        setSelectedFiles(files);

        const previews = files.map((file) => URL.createObjectURL(file));
        setFilePreviews(previews);
    };

    return (
        <>
            <Layout>
                <div className="row">
                    <div className="col-md">
                        <div className="row">
                            <div className="col-md-2">
                                <button
                                    className="btn btn-sm btn-primary mb-3"
                                    onClick={(e) => ChangeCreate()}
                                >
                                    Create
                                </button>
                            </div>
                            <div className="col-md"></div>
                        </div>
                        {create == true && (
                            <>
                                <div className="col-md-8">
                                    <div class="card border-0 ps-2 shadow">
                                        <div class="card-body">
                                            <div className="row">
                                                <div className="col-md-4">
                                                    <label>Name:</label>
                                                    <input
                                                        type="text"
                                                        className="form-control"
                                                        onChange={(e) =>
                                                            setName(
                                                                e.target.value
                                                            )
                                                        }
                                                    />
                                                </div>
                                                <div className="col-md-4">
                                                    <label>Price:</label>
                                                    <input
                                                        type="number"
                                                        className="form-control"
                                                        onChange={(e) =>
                                                            setPrice(
                                                                e.target.value
                                                            )
                                                        }
                                                    />
                                                </div>
                                                <div className="col-md-4">
                                                    <label>Discount:</label>
                                                    <input
                                                        type="number"
                                                        className="form-control"
                                                        onChange={(e) =>
                                                            setDiscount(
                                                                e.target.value
                                                            )
                                                        }
                                                    />
                                                </div>
                                                <div className="col-md-4">
                                                    <label>Màu sắc:</label>
                                                    <input
                                                        type="text"
                                                        className="form-control"
                                                        onChange={(e) =>
                                                            setColor(
                                                                e.target.value
                                                            )
                                                        }
                                                    />
                                                </div>
                                                <div className="col-md-4">
                                                    <label>Tồn kho :</label>
                                                    <input
                                                        type="number"
                                                        className="form-control"
                                                        onChange={(e) =>
                                                            setInstock(
                                                                e.target.value
                                                            )
                                                        }
                                                    />
                                                </div>
                                            </div>
                                            <div className="row mt-2">
                                                <div className="col-md-3">
                                                    <InputLabel id="demo-multiple-name-label">
                                                        Danh mục sản phầm
                                                    </InputLabel>
                                                    <Select
                                                        labelId="demo-multiple-name-label"
                                                        id="demo-multiple-name"
                                                        multiple
                                                        value={cate}
                                                        onChange={handleChange}
                                                        className="form-control"
                                                        input={
                                                            <OutlinedInput label="Name" />
                                                        }
                                                    >
                                                        {categories.map(
                                                            (item) => (
                                                                <MenuItem
                                                                    key={
                                                                        item.id
                                                                    }
                                                                    value={
                                                                        item.id
                                                                    }
                                                                >
                                                                    {item.name}
                                                                </MenuItem>
                                                            )
                                                        )}
                                                    </Select>
                                                </div>
                                                <div className="col-md-3">
                                                    <label>Brands:</label>
                                                    <select
                                                        name="brandId"
                                                        defaultValue={0}
                                                        className="form-control"
                                                        value={idBrand}
                                                        onChange={(e) =>
                                                            setIdBrand(
                                                                e.target.value
                                                            )
                                                        }
                                                    >
                                                        <option
                                                            value="0"
                                                            disabled
                                                        >
                                                            Chọn thương hiệu
                                                        </option>
                                                        {brands.map((brand) => (
                                                            <option
                                                                key={brand.id}
                                                                value={brand.id}
                                                            >
                                                                {brand.name}
                                                            </option>
                                                        ))}
                                                    </select>
                                                </div>
                                            </div>
                                            <div className="row mb-2 mt-2">
                                                <div className="col-md-3">
                                                    <input
                                                        type="file"
                                                        accept="image/*"
                                                        multiple
                                                        onChange={
                                                            handleImageChange
                                                        }
                                                    />
                                                </div>
                                            </div>
                                            <div className="row mt-3">
                                                <div className="col-md">
                                                    <CKEditor
                                                        value={content}
                                                        onBlur={setContent}
                                                    />
                                                </div>
                                            </div>

                                            <div className="row mt-3">
                                                <div
                                                    className="col-md"
                                                    style={{
                                                        display: "grid",
                                                        gridTemplateColumns:
                                                            "repeat(auto-fill, minmax(100px, 1fr))",
                                                        gap: "10px",
                                                    }}
                                                >
                                                    {filePreviews.map(
                                                        (image, index) => (
                                                            <div
                                                                key={index}
                                                                style={{
                                                                    display:
                                                                        "flex",
                                                                    flexDirection:
                                                                        "column",
                                                                    alignItems:
                                                                        "center",
                                                                    marginTop:
                                                                        "10px",
                                                                }}
                                                            >
                                                                <img
                                                                    src={image}
                                                                    alt={`Preview ${index}`}
                                                                    style={{
                                                                        width: "100px",
                                                                        height: "100px",
                                                                        marginBottom:
                                                                            "5px",
                                                                    }}
                                                                />
                                                                <button
                                                                    className="btn btn-danger btn-sm w-100"
                                                                    onClick={() =>
                                                                        handleRemoveImage(
                                                                            index
                                                                        )
                                                                    }
                                                                >
                                                                    Remove
                                                                </button>
                                                            </div>
                                                        )
                                                    )}
                                                </div>
                                            </div>
                                            <div className="row">
                                                <div className="col-md-2">
                                                    {create == true && (
                                                        <button
                                                            className="btn w-100  btn-primary"
                                                            onClick={(e) =>
                                                                SubmitProduct()
                                                            }
                                                        >
                                                            Store
                                                        </button>
                                                    )}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </>
                        )}
                        {create == false && products && products.length > 0 && (
                            <Box sx={{ height: 400 }}>
                                <DataGrid
                                    rows={products}
                                    columns={columns}
                                    slots={{
                                        toolbar: GridToolbar,
                                    }}
                                    initialState={{
                                        pagination: {
                                            paginationModel: {
                                                pageSize: 5,
                                            },
                                        },
                                    }}
                                    pageSizeOptions={[5]}
                                    checkboxSelection
                                    disableRowSelectionOnClick
                                    onCellEditStop={(params, e) =>
                                        handleCellEditStop(
                                            params.row.id,
                                            params.field,
                                            e.target.value
                                        )
                                    }
                                />
                            </Box>
                        )}
                    </div>
                </div>
            </Layout>
        </>
    );
}

export default Index;
