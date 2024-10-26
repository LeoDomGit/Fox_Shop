import React from 'react'
import Layout from '../../components/Layout'

function Edit({dataId,category}) {
  return (
      <Layout>
          <div>
              <div className="container">
                  <h2>Chỉnh sửa danh mục</h2>

                  <div className="form-group">
                      <label htmlFor="name">Tên danh mục</label>
                      <input
                          type="text"
                          className="form-control"
                          value={category.name}
                          name="name"
                          placeholder="Tên danh mục"
                      />
                  </div>
                  <div className="form-group">
                      <label htmlFor="name">Tên danh mục</label>
                      <input
                          type="text"
                          className="form-control"
                          value={category.position}
                          name="name"
                          placeholder="Tên danh mục"
                      />
                  </div>
              </div>
          </div>
      </Layout>
  );
}

export default Edit