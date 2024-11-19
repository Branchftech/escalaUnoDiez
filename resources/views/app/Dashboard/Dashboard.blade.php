<x-app-layout>
    <x-slot name="header">
            {{ __('Escala Uno Diez') }}
    </x-slot>

    <div style="margin: 20px; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
        <div style="margin: 0 auto;">
            <!-- ======================= Cards ================== -->
            <div class="cardBox">
                <div class="card" style="background: #663399; height: 100%">
                    <div class="justify-content-between d-flex align-items-center h-100">
                        <div class="justify-content-between d-flex flex-column align-items-between h-100">
                            <div class="cardName" >Total Gastos del Mes</div>
                            <div class="numbers">${{ number_format($egresosMensual, 2) }}</div>
                        </div>
                        <div class="iconBx d-flex justify-content-center align-items-center" >
                            <i class="fa-solid fa-bag-shopping"></i>
                        </div>
                    </div>
                </div>

                <div class="card" style="background: #0a8ebe; height: 100%">
                    <div class="justify-content-between d-flex align-items-center h-100">
                        <div class="justify-content-between d-flex flex-column align-items-between h-100">
                            <div class="cardName">Total Ingresos del Mes</div>
                            <div class="numbers">${{ number_format($ingresosMensual, 2) }}</div>
                        </div>
                        <div class="iconBx d-flex justify-content-center align-items-center" >
                            <i class="fa-solid fa-sack-dollar"></i>
                        </div>
                    </div>
                </div>

                <div class="card" style="background:#ffcc00; height: 100%">
                    <div class="justify-content-between d-flex align-items-center h-100">
                        <div class="justify-content-between d-flex flex-column align-items-between h-100">
                            <div class="cardName">Obras proceso</div>
                            <div class="numbers">{{$obrasPendiente }}</div>
                        </div>
                        <div class="iconBx d-flex justify-content-center align-items-center" >
                            <i class="fa-solid fa-user-group"></i>
                        </div>
                    </div>
                </div>

                <div class="card" style="background:#ff6600; height: 100%">
                    <div class="justify-content-between d-flex align-items-center h-100">
                        <div class="justify-content-between d-flex flex-column align-items-between h-100">
                            <div class="cardName">Obras con retraso</div>
                            <div class="numbers">{{$obrasVencida }}</div>
                        </div>
                        <div class="iconBx d-flex justify-content-center align-items-center" >
                            <i class="fa-solid fa-user-check"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ================ Order Details List ================= -->
            <div class="details" style="height: auto">
                <div class="recentOrders">
                    @livewire('graficos.graficos')
                </div>
                <div class="recentOrders">
                    <div class="card" style="background: white; border: none; height: auto; width: auto; display: flex; justify-content: center; align-items: center;">
                        <div style="text-align: center; display: flex; flex-direction: column; justify-content: center; align-items: center; height: 100%;">
                            <div class="cardName" style="color: black; font-size: 30px;">Total Nuevos Contratos Anual</div>
                            <div class="numbers" style="color: green; font-size: 70px; padding-top: 10px;">{{$cantContratosNuevos}}</div>
                        </div>
                    </div>
                </div>
                    <!-- <table>
                        <thead>
                            <tr>
                                <td>Name</td>
                                <td>Price</td>
                                <td>Payment</td>
                                <td>Status</td>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>Star Refrigerator</td>
                                <td>$1200</td>
                                <td>Paid</td>
                                <td><span class="status delivered">Delivered</span></td>
                            </tr>

                            <tr>
                                <td>Dell Laptop</td>
                                <td>$110</td>
                                <td>Due</td>
                                <td><span class="status pending">Pending</span></td>
                            </tr>

                            <tr>
                                <td>Apple Watch</td>
                                <td>$1200</td>
                                <td>Paid</td>
                                <td><span class="status return">Return</span></td>
                            </tr>

                            <tr>
                                <td>Addidas Shoes</td>
                                <td>$620</td>
                                <td>Due</td>
                                <td><span class="status inProgress">In Progress</span></td>
                            </tr>

                            <tr>
                                <td>Star Refrigerator</td>
                                <td>$1200</td>
                                <td>Paid</td>
                                <td><span class="status delivered">Delivered</span></td>
                            </tr>

                            <tr>
                                <td>Dell Laptop</td>
                                <td>$110</td>
                                <td>Due</td>
                                <td><span class="status pending">Pending</span></td>
                            </tr>

                            <tr>
                                <td>Apple Watch</td>
                                <td>$1200</td>
                                <td>Paid</td>
                                <td><span class="status return">Return</span></td>
                            </tr>

                            <tr>
                                <td>Addidas Shoes</td>
                                <td>$620</td>
                                <td>Due</td>
                                <td><span class="status inProgress">In Progress</span></td>
                            </tr>
                        </tbody>
                    </table> -->

                <!-- ================= New Customers ================ -->
                <!-- <div class="recentCustomers">
                    <div class="cardHeader">
                        <h2>Recent Customers</h2>
                    </div>

                    <table>
                        <tr>
                            <td width="60px">
                                <div class="imgBx"><img src="assets/imgs/customer02.jpg" alt=""></div>
                            </td>
                            <td>
                                <h4>David <br> <span>Italy</span></h4>
                            </td>
                        </tr>

                        <tr>
                            <td width="60px">
                                <div class="imgBx"><img src="assets/imgs/customer01.jpg" alt=""></div>
                            </td>
                            <td>
                                <h4>Amit <br> <span>India</span></h4>
                            </td>
                        </tr>

                        <tr>
                            <td width="60px">
                                <div class="imgBx"><img src="assets/imgs/customer02.jpg" alt=""></div>
                            </td>
                            <td>
                                <h4>David <br> <span>Italy</span></h4>
                            </td>
                        </tr>

                        <tr>
                            <td width="60px">
                                <div class="imgBx"><img src="assets/imgs/customer01.jpg" alt=""></div>
                            </td>
                            <td>
                                <h4>Amit <br> <span>India</span></h4>
                            </td>
                        </tr>

                        <tr>
                            <td width="60px">
                                <div class="imgBx"><img src="assets/imgs/customer02.jpg" alt=""></div>
                            </td>
                            <td>
                                <h4>David <br> <span>Italy</span></h4>
                            </td>
                        </tr>

                        <tr>
                            <td width="60px">
                                <div class="imgBx"><img src="assets/imgs/customer01.jpg" alt=""></div>
                            </td>
                            <td>
                                <h4>Amit <br> <span>India</span></h4>
                            </td>
                        </tr>

                        <tr>
                            <td width="60px">
                                <div class="imgBx"><img src="assets/imgs/customer01.jpg" alt=""></div>
                            </td>
                            <td>
                                <h4>David <br> <span>Italy</span></h4>
                            </td>
                        </tr>

                        <tr>
                            <td width="60px">
                                <div class="imgBx"><img src="assets/imgs/customer02.jpg" alt=""></div>
                            </td>
                            <td>
                                <h4>Amit <br> <span>India</span></h4>
                            </td>
                        </tr>
                    </table>
                </div> -->
            </div>
        </div>
    </div>

</x-app-layout>
