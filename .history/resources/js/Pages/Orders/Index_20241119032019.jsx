import React, { useEffect, useState } from "react";
import Layout from "../../components/Layout";
import Container from "@mui/material/Container";
import Form from "react-bootstrap/Form";
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import Button from "react-bootstrap/Button";
import { Table, Pagination } from "react-bootstrap";
function Index(orders) {
    console.log(orders);
    const [data, setData] = useState(orders);
    return (
        <Layout>
            <Container>
                <div>
                    <h3>Quản lý đơn hàng</h3>
                </div>
                <div className="row mt-3">
                    <Form inline>
                        <Row>
                            <Col xs="4">
                                <Form.Control
                                    type="text"
                                    placeholder="Tìm kiếm đơn hàng"
                                    className=" mr-sm-2"
                                    // value={searchQuery}
                                    // onChange={handleSearch}
                                />
                            </Col>
                            <Col xs="auto">
                                <Button type="submit">Tìm kiếm</Button>
                            </Col>
                        </Row>
                    </Form>
                </div>
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
                                    <th onClick={() => handleSort("id")}>
                                        # {renderSortArrow("id")}
                                    </th>
                                    <th>Hình ảnh</th>
                                    <th onClick={() => handleSort("name")}>
                                        Tên {renderSortArrow("name")}
                                    </th>
                                    <th>Slug</th>
                                    <th onClick={() => handleSort("status")}>
                                        Trạng thái {renderSortArrow("status")}
                                    </th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                {filteredData.map((item, index) => (
                                    <tr key={item.id}>
                                        <td>
                                            <input type="checkbox" />
                                        </td>
                                        <td>{indexOfFirstItem + index + 1}</td>
                                        <td>
                                            <img
                                                src={item.images}
                                                alt={item.name}
                                                style={{
                                                    width: "50px",
                                                    height: "50px",
                                                }}
                                            />
                                        </td>
                                        <td>{item.name}</td>
                                        <td>{item.slug}</td>
                                        <td>
                                            <Switch
                                                checked={item.status === 1}
                                                onChange={() =>
                                                    handleChangeSwitch(item.id)
                                                }
                                            />
                                        </td>
                                        <td>
                                            <div className="d-flex">
                                                <div>
                                                    <a
                                                        className="btn btn-sm btn-warning"
                                                        href={`/admin/categories/${item.id}`}
                                                    >
                                                        Sửa
                                                    </a>
                                                </div>
                                                <div className="p-2 pt-0 pb-0">
                                                    |
                                                </div>
                                                <div>
                                                    <button
                                                        className="btn btn-sm btn-danger"
                                                        onClick={(e) =>
                                                            handleDelete(
                                                                item.id
                                                            )
                                                        }
                                                    >
                                                        Xóa
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </Table>
                    </div>
                </div>
            </Container>
        </Layout>
    );
}

export default Index;
