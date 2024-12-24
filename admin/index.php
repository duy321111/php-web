<?php 
  include 'inc/header.php';
  include 'dashboard.php'; 
?>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<style>
  .chart-container {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
  }
  .chart {
    width: 45%;
    min-width: 300px;
    margin: 20px 0;
  }
</style>
      <h1 class="dashboard-title">Dashboard</h1>
      <div class="chart-container">
        <div class="chart">
          <p>Thống kê năm và tổng số tiền:</p>
          <div id="linechart" style="height: 250px;"></div>
        </div>
        <div class="chart">
          <p>Thống kê số lượng khách hàng của mỗi tỉnh:</p>
          <div id="customerChart" style="height: 250px;"></div>
        </div>
        <div class="chart">
          <p>Thống kê số lượng sản phẩm bán ra:</p>
          <div id="productChart" style="height: 250px;"></div>
        </div>
        <div class="chart">
          <p>Thống kê tổng số tiền theo tháng:</p>
          <div id="monthlyChart" style="height: 250px;"></div>
        </div>
      </div>

  <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
  <!-- Biểu đồ thống kê đơn hàng dạng đường (line chart) -->
  <script>
    new Morris.Line({
      element: 'linechart',
      data: chartData1,
      xkey: 'year',
      ykeys: ['value'],
      labels: ['Value']
    });
  </script>

  <!-- Biểu đồ thống kê số lượng khách hàng theo tỉnh (donut chart biểu đồ tròn) -->
 <script>
    new Morris.Donut({
      element: 'customerChart',
      data: chartData2,
      formatter: function (x) { return x + " khách hàng"}
    });
  </script>

  <!-- Biểu đồ thống kê số lượng sản phẩm bán ra (bar chart) -->
  <script>
    new Morris.Bar({
      element: 'productChart',
      data: chartData3,
      xkey: 'label',
      ykeys: ['value'],
      labels: ['Quantity']
    });
  </script>

  <!-- Biểu đồ thống kê tổng số tiền theo tháng (line chart) -->
  <script>
    new Morris.Line({
      element: 'monthlyChart',
      data: chartData4,
      xkey: 'month',
      ykeys: ['value'],
      labels: ['Total Amount']
    });
  </script>
<?php 
  include 'inc/footer.php'; 
?>