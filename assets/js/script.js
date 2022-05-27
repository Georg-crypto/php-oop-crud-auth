
const mainUrl = "http://localhost/PAV2022/OOP";

function remove (type, id)
{
    if (confirm('Вы действительно хотите удалить эту запись?')) {
        window.location.href = `${mainUrl}/${type}/delete/${id}`;
    }
}