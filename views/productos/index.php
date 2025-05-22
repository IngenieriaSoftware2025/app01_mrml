<div class="container main-content">
    <main>
        <h1 class="title">¡Añade tus Productos!</h1>
        <p class="subtitle">Personaliza tu lista de compras fácilmente</p>

        <div class="welcome-message">
            <div class="message-icon">
                <i class="bi bi-heart-fill"></i>
            </div>
            <p>
                Queremos hacer tu día a día más sencillo.
                <span class="text-highlight">Añade los productos que necesitas</span>
                y organízalos por categorías para que tus compras sean más eficientes.
                ¡Tu tiempo es valioso!
            </p>
        </div>

        <div class="row mt-4">
            <div class="col-lg-8 mx-auto">
                <div class="form-card">
                    <div class="form-header">
                        <i class="bi bi-basket-fill"></i>
                        <h4>Datos del Producto</h4>
                    </div>

                    <form id="formProducto" method="POST">
                        <!-- Campo oculto para el ID (necesario para ediciones) -->
                        <input type="hidden" id="id" name="id_producto">
                        
                        <div class="row g-3">
                            <div class="col-md-7">
                                <label for="nombre" class="form-label">Nombre del Producto</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-tag"></i></span>
                                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ej: Papel higiénico" required>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <label for="cantidad" class="form-label">Cantidad</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-123"></i></span>
                                    <input type="number" class="form-control" id="cantidad" name="cantidad" min="1" value="1" required>
                                </div>
                            </div>

                            
                            <div class="col-md-6">
                                <label for="id_categoria" class="form-label">Categoría</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-bookmarks"></i></span>
                                    <select class="form-select" id="id_categoria" name="id_categoria" required>
                                        <option value="">Seleccionar...</option>
                                        <?php if (isset($categorias) && !empty($categorias)): ?>
                                            <?php foreach($categorias as $cat): ?>
                                                <option value="<?= $cat->id_categoria ?>"><?= $cat->nombre ?></option>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <option value="" disabled>No hay categorías disponibles</option>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>

<div class="col-md-6">
    <label for="id_prioridad" class="form-label">Prioridad</label>
    <div class="input-group">
        <span class="input-group-text"><i class="bi bi-star"></i></span>
        <select class="form-select" id="id_prioridad" name="id_prioridad" required>
            <option value="">Seleccionar...</option>
            <?php if (isset($prioridades) && !empty($prioridades)): ?>
                <?php foreach($prioridades as $p): ?>
                    <!-- Debug temporal: <?= "ID: " . $p->id_prioridad . " - Nivel: " . $p->nivel ?> -->
                    <option value="<?= $p->id_prioridad ?>"><?= $p->nivel ?></option>
                <?php endforeach; ?>
            <?php else: ?>
                <option value="" disabled>No hay prioridades disponibles</option>
            <?php endif; ?>
        </select>
    </div>
</div>

                            <div class="col-12">
                                <label for="notas_adicionales" class="form-label">Notas Adicionales (opcional)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-pencil"></i></span>
                                    <textarea class="form-control" id="notas_adicionales" name="notas_adicionales" rows="2" placeholder="Alguna especificación o detalle importante"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-buttons mt-4 d-flex justify-content-between">
                            <div>
                                <a href="/app01_mrml" class="btn btn-secondary me-2">
                                    <i class="bi bi-arrow-left me-1"></i>Volver
                                </a>
                                <button type="button" class="btn btn-warning" id="BtnLimpiar">
                                    <i class="bi bi-eraser me-1"></i>Limpiar
                                </button>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary" id="BtnGuardar">
                                    <i class="bi bi-save me-1"></i>Guardar Producto
                                </button>
                                <button type="button" class="btn btn-success d-none" id="BtnModificar">
                                    <i class="bi bi-pencil-square me-1"></i>Modificar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sección de productos pendientes -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-warning">
                        <h5 class="mb-0"><i class="bi bi-basket me-2"></i>Productos Pendientes</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="TableProductosPendientes">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Categoría</th>
                                        <th>Prioridad</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de productos comprados -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="bi bi-check-circle me-2"></i>Productos Comprados</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="TableProductosComprados">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Categoría</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script src="<?= asset('build/js/productos/index.js') ?>"></script>