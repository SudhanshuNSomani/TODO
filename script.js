let table = new DataTable('#myTable');
let edits = document.getElementsByClassName('edits');

Array.from(edits).forEach( 
    (edit) =>{
        edit.addEventListener(
            "click" , (event) =>{
                let tr = event.target.parentNode.parentNode;
                let title = tr.getElementsByTagName("td")[0].innerText;
                let description = tr.getElementsByTagName("td")[1].innerText;
                console.log(title, description);
                descriptionEdit.value = description;
                titleEdit.value = title;
                $('#editModal').modal('toggle');
            }
        );
    }
    
    );