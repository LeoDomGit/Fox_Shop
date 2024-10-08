import React from 'react'
import { useState } from "react";
import Layout from "../../components/Layout"
import { Dropzone, FileMosaic } from "@files-ui/react";
import { CKEditor } from '@ckeditor/ckeditor5-react';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import Button from '@mui/material/Button';
import DeleteIcon from '@mui/icons-material/Delete';
import SendIcon from '@mui/icons-material/Send';
import Stack from '@mui/material/Stack';

function Index() {
    const [files, setFiles] = React.useState([]);
    const [editorData, setEditorData] = useState('');
    const updateFiles = (incommingFiles) => {
        //do something with the files
        setFiles(incommingFiles);
        //even your own upload implementation
    };
    const removeFile = (id) => {
        setFiles(files.filter((x) => x.id !== id));
    };

    return (
        <Layout>
            <div className="container">
                <div className="card">
                    <div className="card-header">
                        <h3>Danh sách sản phẩm</h3>
                    </div>
                    <div className="card-body">
                        <div className="row mt-">
                            <div className="col-md-8">
                                <div>
                                    <label className='form-lable' htmlFor="name">Name:</label>
                                    <input className='form-control' type="text" name='' placeholder='Nhập tên sản phẩm' />
                                </div>
                                <div>
                                    <label className='form-lable' htmlFor="price">Price:</label>
                                    <input className='form-control' type="number" name='' placeholder='Price' />
                                </div>
                                <div>
                                    <label className='form-lable' htmlFor="discount">Discount:</label>
                                    <input className='form-control' type="number" name='' placeholder='Nhập giá giảm sản phẩm' />
                                </div>
                                <div>
                                    <label className='form-lable' htmlFor="mota">Mô tả:</label>
                                    <div>
                                        <CKEditor
                                            editor={ClassicEditor}
                                            data={editorData}
                                            onChange={(event, editor) => {
                                            const data = editor.getData();
                                            setEditorData(data);
                                            }}
                                        />
                                    </div>
                                </div>
                            </div>
                            <div className="col-md-4">
                                <div className="form-control">
                                    <label className='form-lable' htmlFor="category">Danh mục sản phẩm
                                    </label>
                                    <div className="form-control">
                                    <option value="1">Danh mục 1</option>
                                    <option value="2">Danh mục 2</option>
                                    </div>
                                </div>
                                <Dropzone
                                    onChange={updateFiles}
                                    value={files}
                                    accept="image/*"
                                    maxFileSize={28 * 1024}
                                    maxFiles={2}
                                    //cleanFiles
                                    actionButtons={{ position: "bottom", cleanButton: {} }}
                                >
                                {files.map((file) => (
                                    <FileMosaic key={file.id} {...file} onDelete={removeFile} info />
                                    ))}
                                </Dropzone>

                            </div>
                        </div>
                    </div>
                    <div className="card-footer">
                    <Stack direction="row" spacing={2}>
      <Button variant="outlined" startIcon={<DeleteIcon />}>
        Hủy nhập
      </Button>
      <Button variant="contained" endIcon={<SendIcon />}>
        Gửi
      </Button>
    </Stack>
                    </div>
                </div>
            </div>
        </Layout>
    )
}

export default Index