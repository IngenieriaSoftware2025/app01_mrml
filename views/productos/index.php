<div class="row justify-content-center p-3">
    <div class="col-lg-10">
        <div class="card custom-card shadow-lg" style="border-radius: 10px; border: 1px solid #007bff;">
            <div class="card-body p-3">
                <div class="row mb-3">
                    <h5 class="text-center mb-2">¡Bienvenido a la Aplicación para organizar las compras del hogar!</h5>
                    <h4 class="text-center mb-2 text-primary">GESTIÓN DE PRODUCTOS</h4>
                </div>

                <div class="row justify-content-center p-5 shadow-lg">
                    <form id="FormProductos">
                        <input type="hidden" id="prod_id" name="prod_id">

                        <div class="row mb-3 justify-content-center">
                            <!-- NOMBRE -->
                            <div class="col-lg-6">
                                <label for="prod_nombre" class="form-label">NOMBRE DEL PRODUCTO</label>
                                <input type="text" class="form-control" id="prod_nombre" name="prod_nombre" placeholder="Ingrese el nombre del producto" required>
                            </div>
                            <!-- CANTIDAD -->
                            <div class="col-lg-6">
                                <label for="prod_cantidad" class="form-label">CANTIDAD</label>
                                <input type="number" class="form-control" id="prod_cantidad" name="prod_cantidad" placeholder="Cantidad" min="1" value="1" required>
                            </div>
                            <!-- CATEGORIA -->
                            <div class="col-lg-6">
                                <label for="cat_id" class="form-label">CATEGORÍA</label>
                                <select class="form-control" id="cat_id" name="cat_id" required>
                                    <option value="">Seleccione una categoría</option>
                                    <?php foreach($categorias as $categoria): ?>
                                        <option value="<?= $categoria->cat_id ?>"><?= $categoria->cat_nombre ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <!-- PRIORIDAD -->
                            <div class="col-lg-6">
                                <label for="pri_id" class="form-label">PRIORIDAD</label>
                                <select class="form-control" id="pri_id" name="pri_id" required>
                                    <option value="">Seleccione una prioridad</option>
                                    <?php foreach($prioridades as $prioridad): ?>
                                        <option value="<?= $prioridad->pri_id ?>"><?= $prioridad->pri_nombre ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <!-- COMPRADO -->
                            <div class="col-lg-6">
                                <label for="comprado" class="form-label">ESTADO</label>
                                <select class="form-control" id="comprado" name="comprado">
                                    <option value="0">Pendiente</option>
                                    <option value="1">Comprado</option>
                                </select>
                            </div>
                        </div>

                        <div class="row justify-content-center mt-5">
                            <div class="col-auto">
                                <button class="btn btn-success" type="submit" id="BtnGuardar">
                                    <i class="bi bi-save"></i> Guardar
                                </button>
                            </div>

                            <div class="col-auto">
                                <button class="btn btn-warning d-none" type="button" id="BtnModificar">
                                    <i class="bi bi-pencil"></i> Modificar
                                </button>
                            </div>

                            <div class="col-auto">
                                <button class="btn btn-secondary" type="reset" id="BtnLimpiar">
                                    <i class="bi bi-x-circle"></i> Limpiar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center p-3">
    <div class="col-lg-10">
        <div class="card custom-card shadow-lg" style="border-radius: 10px; border: 1px solid #007bff;">
            <div class="card-body p-3">
                <h3 class="text-center">LISTA DE PRODUCTOS</h3>

                <div class="table-responsive p-2">
                    <table class="table table-striped table-hover table-bordered w-100 table-sm" id="TableProductos">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Categoría</th>
                                <th>Prioridad</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Los datos se cargarán via JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/productos/index.js') ?>"></script>