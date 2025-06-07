<style>
.file-drop-area {
    position: relative;
    width: 100%;
    padding: 30px;
    border: 2px dashed #6c757d;
    border-radius: 10px;
    text-align: center;
    cursor: pointer;
    transition: background 0.3s, border-color 0.3s;
}

.file-drop-area:hover {
    background-color: #f8f9fa;
    border-color: #007bff;
}

.file-message {
    font-size: 16px;
    color: #6c757d;
}

.file-input {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
}

.file-list {
    margin-top: 10px;
    padding-left: 0;
    list-style: none;
}

.file-list li {
    margin-bottom: 5px;
    font-size: 14px;
    color: #343a40;
}
</style>