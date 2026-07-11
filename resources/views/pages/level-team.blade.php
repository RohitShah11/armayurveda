@extends('layouts.app')

@section('title', 'Level Wise Team Member')
@section('page-title', 'Level Wise Team Member')

@push('styles')
<style>
.page-
.card-box{background:#fff;border-radius:18px;padding:25px;box-shadow:0 8px 25px rgba(0,0,0,.07)}
.stat-card{border-left:5px solid var(--primary)}
.stat-card h3{font-weight:900;color:var(--primary)}
.form-control,.form-select{height:46px;border-radius:12px}
.btn-main{background:var(--primary);color:#fff;border-radius:25px;font-weight:700;padding:9px 22px}
.btn-main:hover{background:var(--dark);color:#fff}
.btn-gold{background:var(--gold);color:#fff;border-radius:25px;font-weight:700;padding:9px 22px}
.table thead th{background:var(--primary);color:#fff;white-space:nowrap}
.table td{white-space:nowrap;vertical-align:middle}
.member-img{width:42px;height:42px;border-radius:50%;object-fit:cover}
.badge-basic{background:#e8f5ff;color:#0d6efd}
.badge-zenith{background:#dff7e8;color:#198754}
.badge-inactive{background:#fde2e2;color:#dc3545}
.progress{height:9px;border-radius:20px}
.level-card{border-left:5px solid var(--gold)}
@media(max-width:991px){}
</style>
@endpush

@section('content')
<div class="row g-4 mb-4">
      <div class="col-lg-3 col-md-6">
        <div class="card-box stat-card">
          <p>Total 15 Level Members</p>
          <h3 id="totalMembers">0</h3>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="card-box stat-card">
          <p>Basic Package</p>
          <h3 class="text-primary" id="totalBasic">0</h3>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="card-box stat-card">
          <p>Zenith Package</p>
          <h3 class="text-success" id="totalZenith">0</h3>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="card-box stat-card">
          <p>Inactive Members</p>
          <h3 class="text-danger" id="totalInactive">0</h3>
        </div>
      </div>
    </div>

    <div class="card-box mb-4">
      <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
        <div>
          <h5 class="fw-bold mb-1">15 Level Member Count</h5>
          <p class="text-muted mb-0">Level wise total, Basic, Zenith and Inactive member count.</p>
        </div>
        <div>
          <button class="btn btn-gold btn-sm"><i class="fa fa-file-excel"></i> Export</button>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-bordered align-middle" id="levelSummaryTable">
          <thead>
            <tr>
              <th>Level</th>
              <th>Total Members</th>
              <th>Basic Package</th>
              <th>Zenith Package</th>
              <th>Inactive</th>
              <th>Active %</th>
              <th>View Members</th>
            </tr>
          </thead>
          <tbody></tbody>
          <tfoot>
            <tr class="fw-bold">
              <td>Total</td>
              <td id="footTotal">0</td>
              <td id="footBasic">0</td>
              <td id="footZenith">0</td>
              <td id="footInactive">0</td>
              <td colspan="2">15 Level Total</td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>

    <div class="row g-4 mb-4">
      <div class="col-lg-6">
        <div class="card-box level-card">
          <h5 class="fw-bold mb-3">Package Distribution</h5>
          <p class="mb-1">Basic Package <span class="float-end" id="basicPercent">0%</span></p>
          <div class="progress mb-3"><div class="progress-bar bg-primary" id="basicBar"></div></div>

          <p class="mb-1">Zenith Package <span class="float-end" id="zenithPercent">0%</span></p>
          <div class="progress mb-3"><div class="progress-bar bg-success" id="zenithBar"></div></div>

          <p class="mb-1">Inactive <span class="float-end" id="inactivePercent">0%</span></p>
          <div class="progress"><div class="progress-bar bg-danger" id="inactiveBar"></div></div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="card-box level-card">
          <h5 class="fw-bold mb-3">Quick Level Overview</h5>
          <div class="row g-3">
            <div class="col-6">
              <p class="mb-1">Highest Team Level</p>
              <h4 class="fw-bold text-primary">Level 15</h4>
            </div>
            <div class="col-6">
              <p class="mb-1">Largest Level</p>
              <h4 class="fw-bold text-success">Level 12</h4>
            </div>
            <div class="col-6">
              <p class="mb-1">Lowest Level</p>
              <h4 class="fw-bold text-danger">Level 1</h4>
            </div>
            <div class="col-6">
              <p class="mb-1">Active Package Members</p>
              <h4 class="fw-bold text-warning" id="activeMembersBox">0</h4>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card-box mb-4">
      <h5 class="fw-bold mb-3">Filter Level Wise Member List</h5>

      <div class="row g-3">
        <div class="col-lg-3 col-md-6">
          <label class="form-label">Select Level</label>
          <select class="form-select" id="levelFilter">
            <option value="">All Levels</option>
            <option value="1">Level 1</option>
            <option value="2">Level 2</option>
            <option value="3">Level 3</option>
            <option value="4">Level 4</option>
            <option value="5">Level 5</option>
            <option value="6">Level 6</option>
            <option value="7">Level 7</option>
            <option value="8">Level 8</option>
            <option value="9">Level 9</option>
            <option value="10">Level 10</option>
            <option value="11">Level 11</option>
            <option value="12">Level 12</option>
            <option value="13">Level 13</option>
            <option value="14">Level 14</option>
            <option value="15">Level 15</option>
          </select>
        </div>

        <div class="col-lg-3 col-md-6">
          <label class="form-label">Package Status</label>
          <select class="form-select" id="packageFilter">
            <option value="">All Package</option>
            <option value="Basic">Basic Package</option>
            <option value="Zenith">Zenith Package</option>
            <option value="Inactive">Inactive</option>
          </select>
        </div>

        <div class="col-lg-4 col-md-6">
          <label class="form-label">Search</label>
          <input type="text" class="form-control" id="searchBox" placeholder="Member ID / Name / Mobile">
        </div>

        <div class="col-lg-2 col-md-6 d-flex align-items-end">
          <button class="btn btn-main w-100" onclick="filterMembers()">Search</button>
        </div>
      </div>
    </div>

    <div class="card-box">
      <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
        <div>
          <h5 class="fw-bold mb-1">Level Wise Member List</h5>
          <small id="resultCount">Showing all members</small>
        </div>
        <div>
          <button class="btn btn-outline-secondary btn-sm rounded-pill" onclick="resetFilter()">Reset</button>
          <button class="btn btn-gold btn-sm"><i class="fa fa-file-excel"></i> Export</button>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-bordered align-middle" id="memberTable">
          <thead>
            <tr>
              <th>SL</th>
              <th>Photo</th>
              <th>Member ID</th>
              <th>Name</th>
              <th>Mobile</th>
              <th>Level</th>
              <th>Sponsor ID</th>
              <th>Package</th>
              <th>Joining Date</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>

          <tbody>
            <tr data-level="1" data-package="Zenith"><td>1</td><td><img class="member-img" src="https://cdn-icons-png.flaticon.com/512/149/149071.png"></td><td>ARM1002</td><td>Rahul Sharma</td><td>9876543210</td><td>Level 1</td><td>ARM1001</td><td><span class="badge badge-zenith">Zenith</span></td><td>28 Jun 2026</td><td><span class="badge bg-success">Active</span></td><td><button class="btn btn-sm btn-outline-primary">View</button></td></tr>
            <tr data-level="1" data-package="Basic"><td>2</td><td><img class="member-img" src="https://cdn-icons-png.flaticon.com/512/149/149071.png"></td><td>ARM1003</td><td>Priya Das</td><td>9876501234</td><td>Level 1</td><td>ARM1001</td><td><span class="badge badge-basic">Basic</span></td><td>27 Jun 2026</td><td><span class="badge bg-success">Active</span></td><td><button class="btn btn-sm btn-outline-primary">View</button></td></tr>
            <tr data-level="2" data-package="Zenith"><td>3</td><td><img class="member-img" src="https://cdn-icons-png.flaticon.com/512/149/149071.png"></td><td>ARM1004</td><td>Amit Roy</td><td>9000000000</td><td>Level 2</td><td>ARM1002</td><td><span class="badge badge-zenith">Zenith</span></td><td>26 Jun 2026</td><td><span class="badge bg-success">Active</span></td><td><button class="btn btn-sm btn-outline-primary">View</button></td></tr>
            <tr data-level="2" data-package="Inactive"><td>4</td><td><img class="member-img" src="https://cdn-icons-png.flaticon.com/512/149/149071.png"></td><td>ARM1005</td><td>Subham Pal</td><td>9123456789</td><td>Level 2</td><td>ARM1002</td><td><span class="badge badge-inactive">Inactive</span></td><td>25 Jun 2026</td><td><span class="badge bg-danger">Inactive</span></td><td><button class="btn btn-sm btn-outline-primary">View</button></td></tr>
            <tr data-level="3" data-package="Basic"><td>5</td><td><img class="member-img" src="https://cdn-icons-png.flaticon.com/512/149/149071.png"></td><td>ARM1006</td><td>Mita Sen</td><td>9234567890</td><td>Level 3</td><td>ARM1003</td><td><span class="badge badge-basic">Basic</span></td><td>24 Jun 2026</td><td><span class="badge bg-success">Active</span></td><td><button class="btn btn-sm btn-outline-primary">View</button></td></tr>
            <tr data-level="4" data-package="Zenith"><td>6</td><td><img class="member-img" src="https://cdn-icons-png.flaticon.com/512/149/149071.png"></td><td>ARM1007</td><td>Rakesh Mondal</td><td>9345678901</td><td>Level 4</td><td>ARM1004</td><td><span class="badge badge-zenith">Zenith</span></td><td>23 Jun 2026</td><td><span class="badge bg-success">Active</span></td><td><button class="btn btn-sm btn-outline-primary">View</button></td></tr>
            <tr data-level="5" data-package="Inactive"><td>7</td><td><img class="member-img" src="https://cdn-icons-png.flaticon.com/512/149/149071.png"></td><td>ARM1008</td><td>Soma Ghosh</td><td>9456789012</td><td>Level 5</td><td>ARM1006</td><td><span class="badge badge-inactive">Inactive</span></td><td>22 Jun 2026</td><td><span class="badge bg-danger">Inactive</span></td><td><button class="btn btn-sm btn-outline-primary">View</button></td></tr>
            <tr data-level="6" data-package="Basic"><td>8</td><td><img class="member-img" src="https://cdn-icons-png.flaticon.com/512/149/149071.png"></td><td>ARM1009</td><td>Bikash Dey</td><td>9567890123</td><td>Level 6</td><td>ARM1007</td><td><span class="badge badge-basic">Basic</span></td><td>21 Jun 2026</td><td><span class="badge bg-success">Active</span></td><td><button class="btn btn-sm btn-outline-primary">View</button></td></tr>
            <tr data-level="7" data-package="Zenith"><td>9</td><td><img class="member-img" src="https://cdn-icons-png.flaticon.com/512/149/149071.png"></td><td>ARM1010</td><td>Arindam Pal</td><td>9678901234</td><td>Level 7</td><td>ARM1008</td><td><span class="badge badge-zenith">Zenith</span></td><td>20 Jun 2026</td><td><span class="badge bg-success">Active</span></td><td><button class="btn btn-sm btn-outline-primary">View</button></td></tr>
            <tr data-level="8" data-package="Basic"><td>10</td><td><img class="member-img" src="https://cdn-icons-png.flaticon.com/512/149/149071.png"></td><td>ARM1011</td><td>Nisha Roy</td><td>9789012345</td><td>Level 8</td><td>ARM1009</td><td><span class="badge badge-basic">Basic</span></td><td>19 Jun 2026</td><td><span class="badge bg-success">Active</span></td><td><button class="btn btn-sm btn-outline-primary">View</button></td></tr>
            <tr data-level="9" data-package="Zenith"><td>11</td><td><img class="member-img" src="https://cdn-icons-png.flaticon.com/512/149/149071.png"></td><td>ARM1012</td><td>Sanjay Paul</td><td>9890123456</td><td>Level 9</td><td>ARM1010</td><td><span class="badge badge-zenith">Zenith</span></td><td>18 Jun 2026</td><td><span class="badge bg-success">Active</span></td><td><button class="btn btn-sm btn-outline-primary">View</button></td></tr>
            <tr data-level="10" data-package="Inactive"><td>12</td><td><img class="member-img" src="https://cdn-icons-png.flaticon.com/512/149/149071.png"></td><td>ARM1013</td><td>Kamal Das</td><td>9901234567</td><td>Level 10</td><td>ARM1011</td><td><span class="badge badge-inactive">Inactive</span></td><td>17 Jun 2026</td><td><span class="badge bg-danger">Inactive</span></td><td><button class="btn btn-sm btn-outline-primary">View</button></td></tr>
            <tr data-level="11" data-package="Basic"><td>13</td><td><img class="member-img" src="https://cdn-icons-png.flaticon.com/512/149/149071.png"></td><td>ARM1014</td><td>Rina Saha</td><td>9012345678</td><td>Level 11</td><td>ARM1012</td><td><span class="badge badge-basic">Basic</span></td><td>16 Jun 2026</td><td><span class="badge bg-success">Active</span></td><td><button class="btn btn-sm btn-outline-primary">View</button></td></tr>
            <tr data-level="12" data-package="Zenith"><td>14</td><td><img class="member-img" src="https://cdn-icons-png.flaticon.com/512/149/149071.png"></td><td>ARM1015</td><td>Tapan Ghosh</td><td>9123098765</td><td>Level 12</td><td>ARM1013</td><td><span class="badge badge-zenith">Zenith</span></td><td>15 Jun 2026</td><td><span class="badge bg-success">Active</span></td><td><button class="btn btn-sm btn-outline-primary">View</button></td></tr>
            <tr data-level="13" data-package="Basic"><td>15</td><td><img class="member-img" src="https://cdn-icons-png.flaticon.com/512/149/149071.png"></td><td>ARM1016</td><td>Debu Roy</td><td>9234098765</td><td>Level 13</td><td>ARM1014</td><td><span class="badge badge-basic">Basic</span></td><td>14 Jun 2026</td><td><span class="badge bg-success">Active</span></td><td><button class="btn btn-sm btn-outline-primary">View</button></td></tr>
            <tr data-level="14" data-package="Zenith"><td>16</td><td><img class="member-img" src="https://cdn-icons-png.flaticon.com/512/149/149071.png"></td><td>ARM1017</td><td>Rupam Sen</td><td>9345098765</td><td>Level 14</td><td>ARM1015</td><td><span class="badge badge-zenith">Zenith</span></td><td>13 Jun 2026</td><td><span class="badge bg-success">Active</span></td><td><button class="btn btn-sm btn-outline-primary">View</button></td></tr>
            <tr data-level="15" data-package="Inactive"><td>17</td><td><img class="member-img" src="https://cdn-icons-png.flaticon.com/512/149/149071.png"></td><td>ARM1018</td><td>Sujit Dutta</td><td>9456098765</td><td>Level 15</td><td>ARM1016</td><td><span class="badge badge-inactive">Inactive</span></td><td>12 Jun 2026</td><td><span class="badge bg-danger">Inactive</span></td><td><button class="btn btn-sm btn-outline-primary">View</button></td></tr>
          </tbody>
        </table>
      </div>

    </div>

  </div>
@endsection
