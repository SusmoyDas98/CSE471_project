
function openModal() {
    document.getElementById('dormModal').classList.add('active');
}
function closeModal() {
    document.getElementById('dormModal').classList.remove('active');
}
document.getElementById('roomTypes').addEventListener('blur', function() {
    this.value = this.value.split(',').map(v => v.trim()).filter(v => v.length>0).join(', ');
});