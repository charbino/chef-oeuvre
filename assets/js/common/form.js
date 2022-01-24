export default function init() {
    const fileInputs = document.querySelectorAll('input[type=file]');
    if (fileInputs) {
        fileInputs.forEach(fileInput => {
            fileInput.onchange = () => {
                if (fileInput.files.length > 0) {
                    const fileName = fileInput.parentNode.querySelector('.file-name');
                    if (fileName) {
                        fileName.textContent = fileInput.files[0].name;
                    }
                }
            }
        })
    }
}
