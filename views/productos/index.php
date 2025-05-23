<div class="container py-5">
    <div class="row mb-5 justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-4 bg-light">
                <div class="card-body" style="background: linear-gradient(135deg, #fce4ec, #f3e5f5);">
                    <div class="mb-4 text-center">
                        <h5 class="fw-bold text-muted mb-2">🌸 ¡Bienvenida a tu lista de compras!</h5>
                        <h3 class="fw-bold text-pink mb-0">ORGANIZA TU COMPRA</h3>
                    </div>

                    <form id="FormProducto" class="p-4 bg-white rounded-4 shadow-sm border border-2 border-pink">
                        <input type="hidden" id="id" name="id_producto">

                        <div class="row g-3 mb-3">
                            <div class="col-md-8">
                                <label for="nombre" class="form-label fw-semibold text-purple">✨ Producto</label>
                                <input type="text" class="form-control form-control-lg rounded-pill border-purple" id="nombre" name="nombre" required placeholder="Ej. Toallas Sanitarias">
                            </div>
                            <div class="col-md-4">
                                <label for="cantidad" class="form-label fw-semibold text-purple">🔢 Cantidad</label>
                                <input type="number" class="form-control form-control-lg rounded-pill border-purple" id="cantidad" name="cantidad" min="1" required placeholder="5">
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="id_categoria" class="form-label text-purple">🏷️ Categoría</label>
                                <select name="id_categoria" class="form-select form-select-lg rounded-pill border-pink" id="id_categoria" required>
                                    <option value="">-- Seleccione --</option>
                                    <?php foreach($categorias as $cat): ?>
                                        <option value="<?= $cat->id_categoria ?>"><?= $cat->nombre ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="id_prioridad" class="form-label text-purple">⭐ Prioridad</label>
                                <select name="id_prioridad" class="form-select form-select-lg rounded-pill border-pink" id="id_prioridad" required>
                                    <option value="">-- Seleccione --</option>
                                    <?php foreach($prioridades as $p): ?>
                                        <option value="<?= $p->id_prioridad ?>"><?= $p->nivel ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="notas_adicionales" class="form-label text-purple">📝 Notas Adicionales</label>
                            <textarea class="form-control rounded-3 border-light" id="notas_adicionales" name="notas_adicionales" rows="2" placeholder="Saba, Buenas Noches"></textarea>
                        </div>
                        
                        <div class="d-flex justify-content-center gap-3">
                            <button class="btn btn-pink btn-lg px-4 rounded-pill shadow-sm" type="submit" id="BtnGuardar">
                                💾 Guardar
                            </button>
                            <button class="btn btn-lavender btn-lg px-4 rounded-pill shadow-sm d-none" type="button" id="BtnModificar">
                                ✏️ Modificar
                            </button>
                            <button class="btn btn-light btn-lg px-4 rounded-pill shadow-sm" type="reset" id="BtnLimpiar">
                                🧽 Limpiar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--  SECCIÓN DE TABLAS PARA PRODUCTOS -->
    <div class="row justify-content-center mt-5">
        <div class="col-lg-11">
            <!-- PRODUCTOS PENDIENTES -->
            <div class="card shadow-lg border-0 rounded-3 mb-4">
                <div class="card-body">
                    <h4 class="text-center mb-4 text-primary">
                        <i class="bi bi-list-check"></i>  Productos Pendientes
                    </h4>
                    <div id="TableProductosPendientes">
                        <!-- Aquí se cargarán los productos pendientes -->
                        <div class="text-center py-4">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Cargando...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- PRODUCTOS COMPRADOS -->
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-body">
                    <h4 class="text-center mb-4 text-success">
                        <i class="bi bi-check-circle"></i>  Productos Comprados
                    </h4>
                    <div id="TableProductosComprados">
                        <!-- Aquí se cargarán los productos comprados -->
                        <div class="text-center py-4">
                            <div class="spinner-border text-success" role="status">
                                <span class="visually-hidden">Cargando...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="<?= asset('build/js/productos/index.js') ?>"></script>