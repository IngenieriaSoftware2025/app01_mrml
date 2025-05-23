import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario } from '../funciones';

console.log('📜 Script cargado, esperando DOM...');

document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 DOM cargado, iniciando aplicación...');

    // ✅ ELEMENTOS DEL DOM
    const FormProductos = document.getElementById('FormProducto');
    const BtnGuardar = document.getElementById('BtnGuardar');
    const BtnModificar = document.getElementById('BtnModificar');
    const BtnLimpiar = document.getElementById('BtnLimpiar');

    console.log('📋 Elementos encontrados:', {
        FormProductos: !!FormProductos,
        BtnGuardar: !!BtnGuardar,
        BtnModificar: !!BtnModificar,
        BtnLimpiar: !!BtnLimpiar
    });

    if (!FormProductos) {
        console.error('❌ ERROR: Formulario FormProducto no encontrado');
        return;
    }

    // ✅ TOAST PARA NOTIFICACIONES
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });

    // ✅ FUNCIÓN GUARDAR PRODUCTO
    const GuardarProducto = async (event) => {
        console.log('💾 GuardarProducto ejecutado');
        event.preventDefault();
        
        console.log('🛑 preventDefault ejecutado - página no debería recargar');
        
        BtnGuardar.disabled = true;

        // ✅ VALIDACIÓN MANUAL ESPECÍFICA
        const nombre = document.getElementById('nombre').value.trim();
        const cantidad = document.getElementById('cantidad').value;
        const categoria = document.getElementById('id_categoria').value;
        const prioridad = document.getElementById('id_prioridad').value;

        console.log('🎯 Validando campos específicos:');
        console.log(`  nombre: "${nombre}"`);
        console.log(`  cantidad: "${cantidad}"`);
        console.log(`  categoria: "${categoria}"`);
        console.log(`  prioridad: "${prioridad}"`);

        // VALIDACIÓN ESPECÍFICA
        let errores = [];
        
        if (!nombre || nombre === '') {
            errores.push('El nombre del producto es requerido');
        }
        
        if (!cantidad || cantidad <= 0) {
            errores.push('La cantidad debe ser mayor a 0');
        }
        
        if (!categoria || categoria === '' || categoria === '0') {
            errores.push('Debe seleccionar una categoría');
        }
        
        if (!prioridad || prioridad === '' || prioridad === '0') {
            errores.push('Debe seleccionar una prioridad');
        }

        if (errores.length > 0) {
            console.log('❌ Errores de validación:', errores);
            Swal.fire({
                icon: "error",
                title: "Formulario incompleto",
                html: errores.map(error => `• ${error}`).join('<br>'),
                confirmButtonText: 'Entendido'
            });
            BtnGuardar.disabled = false;
            return;
        }

        console.log('✅ Formulario válido, preparando datos...');

        const body = new FormData(FormProductos);
        
        // MOSTRAR QUÉ DATOS SE ESTÁN ENVIANDO
        console.log('📤 Datos a enviar:');
        for (let [key, value] of body.entries()) {
            console.log(`  ${key}: ${value}`);
        }

        const url = '/app01_mrml/productos/guardarAPI';
        console.log('🌐 URL:', url);

        try {
            console.log('📡 Enviando petición...');
            const res = await fetch(url, { method: 'POST', body });
            console.log('📨 Respuesta recibida:', res.status);
            
            const response = await res.json();
            console.log('📋 Datos de respuesta:', response);

            if (response.codigo == 1) {
                console.log('✅ Éxito!');
                await Swal.fire({ 
                    icon: 'success', 
                    title: 'Éxito', 
                    text: response.mensaje 
                });
                limpiarTodo();
                BuscarProductos();
            } else {
                console.log('❌ Error del servidor:', response.mensaje);
                await Swal.fire({ 
                    icon: 'error', 
                    title: 'Error', 
                    text: response.mensaje
                });
            }
        } catch (e) {
            console.error('💥 Error en GuardarProducto:', e);
            await Swal.fire({
                icon: 'error',
                title: 'Error de conexión',
                text: 'No se pudo conectar con el servidor'
            });
        }
        BtnGuardar.disabled = false;
    }

    // ✅ FUNCIÓN BUSCAR PRODUCTOS
    const BuscarProductos = async () => {
        console.log('🔍 BuscarProductos ejecutado');
        const url = '/app01_mrml/productos/buscarAPI';
        try {
            const res = await fetch(url);
            const response = await res.json();

            console.log('📋 Productos obtenidos:', response);

            if (response.codigo == 1) {
                const pendientes = response.data.filter(p => p.situacion_comprado == 0);
                const comprados = response.data.filter(p => p.situacion_comprado == 1);

                console.log(`📊 Pendientes: ${pendientes.length}, Comprados: ${comprados.length}`);

                mostrarProductosHTML(pendientes, comprados);

                Toast.fire({ icon: 'success', title: response.mensaje });
            } else {
                console.log('❌ Error al buscar:', response.mensaje);
                Swal.fire({ icon: 'info', title: 'Error', text: response.mensaje });
            }
        } catch (e) {
            console.error('💥 Error en BuscarProductos:', e);
        }
    }

    // ✅ FUNCIÓN MOSTRAR PRODUCTOS CON HTML SIMPLE
    const mostrarProductosHTML = (pendientes, comprados) => {
        console.log('📄 Mostrando productos con HTML simple');
        
        // MOSTRAR PENDIENTES
        const containerPendientes = document.getElementById('TableProductosPendientes');
        if (containerPendientes) {
            let htmlPendientes = `
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th>No.</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Categoría</th>
                                <th>Prioridad</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
            `;

            if (pendientes.length === 0) {
                htmlPendientes += `
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            No hay productos pendientes
                        </td>
                    </tr>
                `;
            } else {
                pendientes.forEach((producto, index) => {
                    const prioridadBadge = 
                        producto.prioridad_nombre === 'Alta' ? 'bg-danger' :
                        producto.prioridad_nombre === 'Media' ? 'bg-warning text-dark' :
                        'bg-success';

                    htmlPendientes += `
                        <tr>
                            <td>${index + 1}</td>
                            <td><strong>${producto.nombre}</strong></td>
                            <td><span class="badge bg-secondary">${producto.cantidad}</span></td>
                            <td>${producto.categoria_nombre}</td>
                            <td><span class="badge ${prioridadBadge}">${producto.prioridad_nombre}</span></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button class='btn btn-warning btn-sm modificar' 
                                            data-id='${producto.id_producto}'
                                            data-nombre='${producto.nombre}' 
                                            data-cantidad='${producto.cantidad}'
                                            data-id_categoria='${producto.id_categoria}' 
                                            data-id_prioridad='${producto.id_prioridad}'
                                            title="Editar producto">
                                        <i class='bi bi-pencil'></i>
                                    </button>
                                    <button class='btn btn-success btn-sm marcarComprado' 
                                            data-id='${producto.id_producto}'
                                            title="Marcar como comprado">
                                        <i class='bi bi-check-circle'></i>
                                    </button>
                                    <button class='btn btn-danger btn-sm eliminar' 
                                            data-id='${producto.id_producto}'
                                            title="Eliminar producto">
                                        <i class='bi bi-trash'></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `;
                });
            }

            htmlPendientes += `
                        </tbody>
                    </table>
                </div>
            `;

            containerPendientes.innerHTML = htmlPendientes;
        }

        // MOSTRAR COMPRADOS
        const containerComprados = document.getElementById('TableProductosComprados');
        if (containerComprados) {
            let htmlComprados = `
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-success">
                            <tr>
                                <th>No.</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Categoría</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
            `;

            if (comprados.length === 0) {
                htmlComprados += `
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            <i class="bi bi-check-circle fs-1 d-block mb-2"></i>
                            No hay productos comprados aún
                        </td>
                    </tr>
                `;
            } else {
                comprados.forEach((producto, index) => {
                    htmlComprados += `
                        <tr class="table-success">
                            <td>${index + 1}</td>
                            <td><s class="text-muted">${producto.nombre}</s></td>
                            <td><span class="badge bg-success">${producto.cantidad}</span></td>
                            <td class="text-muted">${producto.categoria_nombre}</td>
                            <td>
                                <button class='btn btn-outline-danger btn-sm desmarcarComprado' 
                                        data-id='${producto.id_producto}'
                                        title="Marcar como pendiente">
                                    <i class='bi bi-x-circle'></i> Desmarcar
                                </button>
                            </td>
                        </tr>
                    `;
                });
            }

            htmlComprados += `
                        </tbody>
                    </table>
                </div>
            `;

            containerComprados.innerHTML = htmlComprados;
        }

        // AGREGAR EVENT LISTENERS A LOS BOTONES DINÁMICOS
        agregarEventListenersBotones();
    }

    // ✅ FUNCIÓN PARA AGREGAR EVENT LISTENERS A BOTONES DINÁMICOS
    const agregarEventListenersBotones = () => {
        console.log('🎯 Agregando event listeners a botones dinámicos...');
        
        // Event listeners para botones de modificar
        document.querySelectorAll('.modificar').forEach(btn => {
            btn.addEventListener('click', llenarFormulario);
        });

        // Event listeners para marcar como comprado
        document.querySelectorAll('.marcarComprado').forEach(btn => {
            btn.addEventListener('click', (e) => cambiarEstado(e.currentTarget.dataset.id, 1));
        });

        // Event listeners para desmarcar comprado
        document.querySelectorAll('.desmarcarComprado').forEach(btn => {
            btn.addEventListener('click', (e) => cambiarEstado(e.currentTarget.dataset.id, 0));
        });

        // Event listeners para eliminar
        document.querySelectorAll('.eliminar').forEach(btn => {
            btn.addEventListener('click', (e) => eliminarProducto(e.currentTarget.dataset.id));
        });
    }

    // ✅ FUNCIÓN LLENAR FORMULARIO
    const llenarFormulario = (e) => {
        console.log('✏️ llenarFormulario ejecutado');
        const d = e.currentTarget.dataset;

        document.getElementById('id').value = d.id;
        document.getElementById('nombre').value = d.nombre;
        document.getElementById('cantidad').value = d.cantidad;
        document.getElementById('id_categoria').value = d.id_categoria;
        document.getElementById('id_prioridad').value = d.id_prioridad;

        BtnGuardar.classList.add('d-none');
        BtnModificar.classList.remove('d-none');

        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // ✅ FUNCIÓN LIMPIAR TODO
    const limpiarTodo = () => {
        console.log('🧽 limpiarTodo ejecutado');
        FormProductos.reset();
        BtnGuardar.classList.remove('d-none');
        BtnModificar.classList.add('d-none');
    }

    // ✅ FUNCIÓN MODIFICAR PRODUCTO
    const ModificarProducto = async (event) => {
        console.log('✏️ ModificarProducto ejecutado');
        event.preventDefault();
        BtnModificar.disabled = true;

        // VALIDACIÓN MANUAL PARA MODIFICAR
        const nombre = document.getElementById('nombre').value.trim();
        const cantidad = document.getElementById('cantidad').value;
        const categoria = document.getElementById('id_categoria').value;
        const prioridad = document.getElementById('id_prioridad').value;

        let errores = [];
        
        if (!nombre || nombre === '') {
            errores.push('El nombre del producto es requerido');
        }
        
        if (!cantidad || cantidad <= 0) {
            errores.push('La cantidad debe ser mayor a 0');
        }
        
        if (!categoria || categoria === '' || categoria === '0') {
            errores.push('Debe seleccionar una categoría');
        }
        
        if (!prioridad || prioridad === '' || prioridad === '0') {
            errores.push('Debe seleccionar una prioridad');
        }

        if (errores.length > 0) {
            Swal.fire({
                icon: "error",
                title: "Formulario incompleto",
                html: errores.map(error => `• ${error}`).join('<br>'),
                confirmButtonText: 'Entendido'
            });
            BtnModificar.disabled = false;
            return;
        }

        const body = new FormData(FormProductos);
        const url = '/app01_mrml/productos/modificarAPI';

        try {
            const res = await fetch(url, { method: 'POST', body });
            const response = await res.json();

            if (response.codigo == 1) {
                await Swal.fire({ 
                    icon: 'success', 
                    title: 'Éxito', 
                    text: response.mensaje 
                });
                limpiarTodo();
                BuscarProductos();
            } else {
                Swal.fire({ 
                    icon: 'error', 
                    title: 'Error', 
                    text: response.mensaje 
                });
            }
        } catch (e) {
            console.error('💥 Error en ModificarProducto:', e);
            Swal.fire({
                icon: 'error',
                title: 'Error de conexión',
                text: 'No se pudo modificar el producto'
            });
        }
        BtnModificar.disabled = false;
    }

    // ✅ FUNCIÓN CAMBIAR ESTADO
    const cambiarEstado = async (id, estado) => {
        console.log(`🔄 cambiarEstado ejecutado: ID=${id}, Estado=${estado}`);
        const body = new FormData();
        body.append('id_producto', id);
        body.append('situacion_comprado', estado);

        const url = '/app01_mrml/productos/cambiarEstadoAPI';
        const config = { method: 'POST', body };

        try {
            const res = await fetch(url, config);
            const response = await res.json();
            
            console.log('🔄 Respuesta cambiar estado:', response);
            
            if (response.codigo == 1) {
                BuscarProductos();
                Toast.fire({ 
                    icon: 'success', 
                    title: estado == 1 ? 'Producto marcado como comprado' : 'Producto marcado como pendiente'
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.mensaje
                });
            }
        } catch (e) { 
            console.error('💥 Error en cambiarEstado:', e);
            Swal.fire({
                icon: 'error',
                title: 'Error de conexión',
                text: 'No se pudo cambiar el estado del producto'
            });
        }
    }

    // ✅ FUNCIÓN ELIMINAR PRODUCTO
    const eliminarProducto = async (id) => {
        console.log(`🗑️ eliminarProducto ejecutado: ID=${id}`);
        
        const confirmacion = await Swal.fire({
            title: '¿Estás segura?',
            text: "¿Deseas eliminar este producto de tu lista?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        });

        if (confirmacion.isConfirmed) {
            const body = new FormData();
            body.append('id_producto', id);

            const url = '/app01_mrml/productos/eliminarAPI';
            const config = { method: 'POST', body };

            try {
                const res = await fetch(url, config);
                const response = await res.json();
                
                if (response.codigo == 1) {
                    BuscarProductos();
                    Toast.fire({ 
                        icon: 'success', 
                        title: 'Producto eliminado correctamente'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.mensaje
                    });
                }
            } catch (e) { 
                console.error('💥 Error en eliminarProducto:', e);
                Swal.fire({
                    icon: 'error',
                    title: 'Error de conexión',
                    text: 'No se pudo eliminar el producto'
                });
            }
        }
    }

    // ✅ AGREGAR EVENT LISTENERS PRINCIPALES
    console.log('🎯 Agregando event listeners principales...');

    if (FormProductos) {
        FormProductos.addEventListener('submit', GuardarProducto);
        console.log('✅ Event listener submit agregado al formulario');
    }

    if (BtnLimpiar) {
        BtnLimpiar.addEventListener('click', limpiarTodo);
        console.log('✅ Event listener click agregado al botón limpiar');
    }

    if (BtnModificar) {
        BtnModificar.addEventListener('click', ModificarProducto);
        console.log('✅ Event listener click agregado al botón modificar');
    }

    // ✅ INICIALIZAR APLICACIÓN
    console.log('🚀 Inicializando aplicación...');
    BuscarProductos();
});