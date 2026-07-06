<?php include 'includes/header.php'; ?>

<!-- Hero Section with Background Image -->
<div class="hero" style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.7)), url('assets/images/hero-bg.jpg') center/cover no-repeat; min-height: 500px; display: flex; flex-direction: column; justify-content: center; align-items: center;">
    <div class="text-center mb-4">
        <img src="assets/images/logo.png" alt="OWUTECH Logo" style="height: 100px; margin-bottom: 20px;" onerror="this.style.display='none'">
        <h1 class="display-4 fw-bold text-white mb-3">Welcome to OWUTECH Hostel Allocation</h1>
        <p class="lead fs-4 text-light">Effortless room booking, automatic allocation, and live availability – all in one place.</p>
        <div class="mt-4">
            <a href="register.php" class="btn btn-light btn-lg me-3 px-4 py-3"><i class="fas fa-user-graduate me-2"></i> Register Now</a>
            <a href="availability.php" class="btn btn-outline-light btn-lg px-4 py-3"><i class="fas fa-door-open me-2"></i> View Rooms</a>
        </div>
    </div>
</div>

<!-- Quick Stats Section -->
<div class="container mt-5">
    <div class="row text-center">
        <div class="col-md-3 mb-4">
            <div class="card p-4 border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-building fa-3x mb-3 text-primary"></i>
                    <h3 class="fw-bold">3</h3>
                    <p class="text-muted">Floors</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card p-4 border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-door-open fa-3x mb-3 text-success"></i>
                    <h3 class="fw-bold">24</h3>
                    <p class="text-muted">Rooms</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card p-4 border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-users fa-3x mb-3 text-info"></i>
                    <h3 class="fw-bold">96</h3>
                    <p class="text-muted">Total Capacity</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card p-4 border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-check-circle fa-3x mb-3 text-warning"></i>
                    <h3 class="fw-bold">4</h3>
                    <p class="text-muted">Per Room</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="container mt-5">
    <h2 class="text-center mb-5 fw-bold">Why Choose OWUTECH Hostel?</h2>
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card p-4 text-center h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3 d-inline-block mb-3">
                        <i class="fas fa-credit-card fa-3x text-primary"></i>
                    </div>
                    <h5 class="fw-bold">Payment Verification</h5>
                    <p class="text-muted">Secure payment through Paystack or upload your payment proof for admin verification.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card p-4 text-center h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="rounded-circle bg-success bg-opacity-10 p-3 d-inline-block mb-3">
                        <i class="fas fa-cogs fa-3x text-success"></i>
                    </div>
                    <h5 class="fw-bold">Auto Allocation</h5>
                    <p class="text-muted">Smart system automatically assigns the next available room after payment verification.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card p-4 text-center h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="rounded-circle bg-warning bg-opacity-10 p-3 d-inline-block mb-3">
                        <i class="fas fa-print fa-3x text-warning"></i>
                    </div>
                    <h5 class="fw-bold">Printable Slips</h5>
                    <p class="text-muted">Download or print your room allocation slip with QR code verification.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- How It Works Section -->
<div class="bg-light mt-5 py-5">
    <div class="container">
        <h2 class="text-center mb-5 fw-bold">How It Works</h2>
        <div class="row">
            <div class="col-md-3 text-center mb-4">
                <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                    <h3 class="text-primary fw-bold m-0">1</h3>
                </div>
                <h6 class="fw-bold">Register Account</h6>
                <p class="text-muted small">Create your student account with basic details</p>
            </div>
            <div class="col-md-3 text-center mb-4">
                <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                    <h3 class="text-success fw-bold m-0">2</h3>
                </div>
                <h6 class="fw-bold">Make Payment</h6>
                <p class="text-muted small">Pay online or upload payment receipt</p>
            </div>
            <div class="col-md-3 text-center mb-4">
                <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                    <h3 class="text-info fw-bold m-0">3</h3>
                </div>
                <h6 class="fw-bold">Get Verified</h6>
                <p class="text-muted small">Admin verifies your payment status</p>
            </div>
            <div class="col-md-3 text-center mb-4">
                <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                    <h3 class="text-warning fw-bold m-0">4</h3>
                </div>
                <h6 class="fw-bold">Book Room</h6>
                <p class="text-muted small">Get automatic room allocation instantly</p>
            </div>
        </div>
    </div>
</div>

<!-- Call to Action -->
<div class="container my-5">
    <div class="card bg-primary text-white text-center p-5 shadow-lg border-0" style="border-radius: 15px;">
        <h2 class="fw-bold mb-3">Ready to Get Started?</h2>
        <p class="lead mb-4">Join hundreds of students already enjoying comfortable hostel accommodation.</p>
        <div>
            <a href="register.php" class="btn btn-light btn-lg me-3 px-5 py-3 fw-bold"><i class="fas fa-user-plus me-2"></i> Register Now</a>
            <a href="login.php" class="btn btn-outline-light btn-lg px-5 py-3 fw-bold"><i class="fas fa-sign-in-alt me-2"></i> Login</a>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>