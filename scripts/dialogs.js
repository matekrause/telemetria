let showAddDataset = false;
let showRmDataset = false;

function clickAction(element) {

    if (element == "addDataset") {
        if (showAddDataset == false) {
            document.getElementById("rmDataset").style.display = "none";
            showRmDataset = false;
            document.getElementById("addDataset").style.display = "block";
            showAddDataset = true;
        } else {
            document.getElementById("addDataset").style.display = "none";
            showAddDataset = false;
        }
    } else if (element == "rmDataset") {
        if (showRmDataset == false) {
            document.getElementById("addDataset").style.display = "none";
            showAddDataset = false;
            document.getElementById("rmDataset").style.display = "block";
            showRmDataset = true;
        } else {
            document.getElementById("rmDataset").style.display = "none";
            showRmDataset = false;
        }
    }

}