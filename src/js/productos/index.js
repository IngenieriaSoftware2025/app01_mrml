// Adaptado a tu formulario personalizado con IDs y names correctos
import Swal from "sweetalert2";
import DataTable from "datatables.net-bs5";
import { validarFormulario, Toast } from '../funciones';
import { lenguaje } from "../lenguaje";

const FormProductos = document.getElementById('formProducto');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnModificar = document.getElementById('BtnModificar');
const BtnLimpiar = document.getElementById('BtnLimpiar');

const GuardarProducto = async (event) => {
    event.preventDefault();
    BtnGuardar.disabled = true;

    if (!validarFormulario(FormProductos, ['id_producto'])) {
        Swal.fire({
            icon: "info",
            title: "Formulario incompleto",
            text: "Debes llenar todos los campos requeridos"
        });
        BtnGuardar.disabled = false;
        return;
    }

    const body = new FormData(FormProductos);
    const url = '/app01_mrml/productos/guardarAPI';

    try {
        const res = await fetch(url, { method: 'POST', body });
        const { codigo, mensaje } = await res.json();

        if (codigo == 1) {
            await Swal.fire({ icon: 'success', title: 'Éxito', text: mensaje });
            limpiarTodo();
            BuscarProductos();
        } else {
            await Swal.fire({ icon: 'info', title: 'Error', text: mensaje });
        }
    } catch (e) {
        console.error(e);
    }
    BtnGuardar.disabled = false;
}

const BuscarProductos = async () => {
    const url = '/app01_mrml/productos/buscarAPI';
    try {
        const res = await fetch(url);
        const { codigo, mensaje, data } = await res.json();

        if (codigo == 1) {
            const pendientes = data.filter(p => p.comprado == 0);
            const comprados = data.filter(p => p.comprado == 1);

            datatablePendientes.clear().rows.add(pendientes).draw();
            datatableComprados.clear().rows.add(comprados).draw();

            Toast.fire({ icon: 'success', title: mensaje });
        } else {
            Swal.fire({ icon: 'info', title: 'Error', text: mensaje });
        }
    } catch (e) {
        console.error(e);
    }
}

const datatablePendientes = new DataTable('#TableProductosPendientes', {
    language: lenguaje,
    data: [],
    columns: [
        { title: 'No.', render: (d, t, r, m) => m.row + 1 },
        { title: 'Producto', data: 'nombre' },
        { title: 'Cantidad', data: 'cantidad' },
        { title: 'Categoría', data: 'categoria' },
        {
            title: 'Prioridad', data: 'prioridad',
            render: data => {
                let badge = 'badge bg-secondary';
                if (data === 'Alta') badge = 'badge bg-danger';
                else if (data === 'Media') badge = 'badge bg-warning text-dark';
                else if (data === 'Baja') badge = 'badge bg-success';
                return `<span class="${badge}">${data}</span>`;
            }
        },
        {
            title: 'Acciones', data: 'id_producto',
            render: (id, t, row) => `
                <button class='btn btn-warning btn-sm modificar' data-id='${id}'
                        data-nombre='${row.nombre}' data-cantidad='${row.cantidad}'
                        data-categoria='${row.id_categoria}' data-prioridad='${row.id_prioridad}'>
                    <i class='bi bi-pencil'></i> Editar
                </button>
                <button class='btn btn-success btn-sm marcarComprado' data-id='${id}'>
                    <i class='bi bi-check-circle'></i> Comprado
                </button>`
        }
    ]
});

const datatableComprados = new DataTable('#TableProductosComprados', {
    language: lenguaje,
    data: [],
    columns: [
        { title: 'No.', render: (d, t, r, m) => m.row + 1 },
        { title: 'Producto', data: 'nombre', render: d => `<s>${d}</s>` },
        { title: 'Cantidad', data: 'cantidad' },
        { title: 'Categoría', data: 'categoria' },
        {
            title: 'Acciones', data: 'id_producto',
            render: id => `
                <button class='btn btn-danger btn-sm desmarcarComprado' data-id='${id}'>
                    <i class='bi bi-x-circle'></i> No Comprado
                </button>`
        }
    ]
});

const llenarFormulario = (e) => {
    const d = e.currentTarget.dataset;
    document.getElementById('id').value = d.id;
    document.getElementById('nombre').value = d.nombre;
    document.getElementById('cantidad').value = d.cantidad;
    document.getElementById('id_categoria').value = d.categoria;
    document.getElementById('id_prioridad').value = d.prioridad;
    BtnGuardar.classList.add('d-none');
    BtnModificar.classList.remove('d-none');
}

const limpiarTodo = () => {
    FormProductos.reset();
    BtnGuardar.classList.remove('d-none');
    BtnModificar.classList.add('d-none');
}

const ModificarProducto = async (event) => {
    event.preventDefault();
    BtnModificar.disabled = true;

    if (!validarFormulario(FormProductos)) {
        Swal.fire({ icon: 'info', title: 'Formulario incompleto' });
        BtnModificar.disabled = false;
        return;
    }

    const body = new FormData(FormProductos);
    const url = '/app01_mrml/productos/modificarAPI';

    try {
        const res = await fetch(url, { method: 'POST', body });
        const { codigo, mensaje } = await res.json();

        if (codigo == 1) {
            await Swal.fire({ icon: 'success', title: 'Éxito', text: mensaje });
            limpiarTodo();
            BuscarProductos();
        } else {
            Swal.fire({ icon: 'info', title: 'Error', text: mensaje });
        }
    } catch (e) {
        console.error(e);
    }
    BtnModificar.disabled = false;
}

const cambiarEstado = async (id, comprado) => {
    const body = new FormData();
    body.append('id', id);
    body.append('comprado', comprado);

    const url = '/app01_mrml/productos/marcarCompradoAPI';
    const config = { method: 'POST', body };

    try {
        const res = await fetch(url, config);
        const { codigo, mensaje } = await res.json();
        if (codigo == 1) BuscarProductos();
    } catch (e) { console.error(e); }
}

// Event listeners
datatablePendientes.on('click', '.modificar', llenarFormulario);
datatablePendientes.on('click', '.marcarComprado', e => cambiarEstado(e.currentTarget.dataset.id, 1));
datatableComprados.on('click', '.desmarcarComprado', e => cambiarEstado(e.currentTarget.dataset.id, 0));

FormProductos.addEventListener('submit', GuardarProducto);
BtnLimpiar.addEventListener('click', limpiarTodo);
BtnModificar.addEventListener('click', ModificarProducto);

BuscarProductos();
