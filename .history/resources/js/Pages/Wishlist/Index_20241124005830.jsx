import React, { useState, useEffect } from "react";
import Layout from "../../components/Layout";
import Container from "@mui/material/Container";
import { Table, Pagination } from "react-bootstrap";
function Index({ wishlist }) {
    const [data, setData] = useState(wishlist);
    const [currentPage, setCurrentPage] = useState(1);
    const itemsPerPage = 5;
    const indexOfLastItem = currentPage * itemsPerPage;
    const indexOfFirstItem = indexOfLastItem - itemsPerPage;
    const totalPages = Math.ceil(pro.length / itemsPerPage);
    const currentData = pro.slice(indexOfFirstItem, indexOfLastItem);
    const handlePageChange = (pageNumber) => {
        setCurrentPage(pageNumber);
    };
    useEffect(() => {
        const storedUser = localStorage.getItem("user");
        if (storedUser) {
            try {
                const parsedUser = JSON.parse(storedUser);
                setUser(parsedUser);
                setUpdatedUser(parsedUser);
            } catch (error) {
                console.error("Failed to parse user data:", error);
            }
        } else {
            window.location.href = "/";
        }
    }, []);
    return (
        <div>
            <Layout>
                <Container>
                    <div>
                        <div>
                            <h3>Quản lý danh sách yêu thích</h3>
                        </div>
                        <div>
                            <div className="card mt-5">
                                <div className="card-header text-center">
                                    <h5>Danh sách đơn hàng</h5>
                                </div>
                                <div className="card-body">
                                    <Table striped>
                                        <thead>
                                            <tr>
                                                <th>
                                                    <input type="checkbox" />
                                                </th>
                                                <th>Mã</th>
                                                <th>Sản phẩm</th>
                                                <th>Mã khách hàng</th>
                                                <th>Ngày tạo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {data &&
                                                data.length > 0 &&
                                                data.map((item) => (
                                                    <tr key={item.id}>
                                                        <td>
                                                            <input type="checkbox" />
                                                        </td>
                                                        <td>{item.id}</td>
                                                        {item.items.map(
                                                            (productItem) => (
                                                                <td
                                                                    key={
                                                                        productItem.id
                                                                    }
                                                                >
                                                                    <div className="d-flex">
                                                                        <div>
                                                                            <img
                                                                                src={`/storage/products/${productItem.product.gallery[0].image}`}
                                                                                alt="Anh"
                                                                                style={{
                                                                                    width: "50px",
                                                                                    height: "50px",
                                                                                }}
                                                                            />
                                                                        </div>
                                                                        <div className="ms-3">
                                                                            <div>
                                                                                <strong>
                                                                                    Mã
                                                                                    sản
                                                                                    phẩm:
                                                                                </strong>
                                                                                <span className="ms-3">
                                                                                    {
                                                                                        productItem
                                                                                            .product
                                                                                            .id
                                                                                    }
                                                                                </span>
                                                                            </div>
                                                                            <div>
                                                                                <strong>
                                                                                    Tên
                                                                                    sản
                                                                                    phẩm:
                                                                                </strong>
                                                                                <span className="ms-3">
                                                                                    {
                                                                                        productItem
                                                                                            .product
                                                                                            .name
                                                                                    }
                                                                                </span>
                                                                            </div>
                                                                            <div>
                                                                                <strong>
                                                                                    Giá
                                                                                    sản
                                                                                    phẩm:
                                                                                </strong>
                                                                                <span className="ms-3">
                                                                                    {
                                                                                        productItem
                                                                                            .product
                                                                                            .price
                                                                                    }
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            )
                                                        )}
                                                        <td>{item.id_user}</td>
                                                        <td>
                                                            {item.create_date}
                                                        </td>
                                                    </tr>
                                                ))}
                                        </tbody>
                                    </Table>
                                </div>
                                <div className="card-footer">
                                    <Pagination className="justify-content-center">
                                        <Pagination.First
                                            onClick={() => handlePageChange(1)}
                                            disabled={currentPage === 1}
                                        />
                                        <Pagination.Prev
                                            onClick={() =>
                                                handlePageChange(
                                                    currentPage - 1
                                                )
                                            }
                                            disabled={currentPage === 1}
                                        />
                                        {[...Array(totalPages).keys()].map(
                                            (page) => (
                                                <Pagination.Item
                                                    key={page + 1}
                                                    active={
                                                        page + 1 === currentPage
                                                    }
                                                    onClick={() =>
                                                        handlePageChange(
                                                            page + 1
                                                        )
                                                    }
                                                >
                                                    {page + 1}
                                                </Pagination.Item>
                                            )
                                        )}
                                        <Pagination.Next
                                            onClick={() =>
                                                handlePageChange(
                                                    currentPage + 1
                                                )
                                            }
                                            disabled={
                                                currentPage === totalPages
                                            }
                                        />
                                        <Pagination.Last
                                            onClick={() =>
                                                handlePageChange(totalPages)
                                            }
                                            disabled={
                                                currentPage === totalPages
                                            }
                                        />
                                    </Pagination>
                                </div>
                            </div>
                        </div>
                    </div>
                </Container>
            </Layout>
        </div>
    );
}

export default Index;