# VIP 會員贈獎查詢與統計平台

## 專案簡介

此專案是 Laravel + Vue 開發的會員贈獎查詢與統計平台作品，主要用於展示後端資料庫整合、報表查詢、資料匯入及前端互動介面的實作能力。

本專案僅作為作品展示用途，**不是可直接下載後使用的完整產品**。專案依賴特定的資料庫結構、內部設定檔、企業環境及資料來源；公開版本無法提供必要的資料庫帳密、測試資料與外部服務連線資訊，因此無法保證直接部署後即可正常運作。

## 功能展示

- 首頁與導覽列展示
- 會員贈獎資料查詢
- 日期區間報表統計
- 人次與不重複人數統計
- 贈獎項目與每日數量統計
- 從 SQL Server 擷取資料後匯入 Oracle
- 動態設定最後執行日期
- 資料匯入前後的日期與重複執行檢查

## 使用技術

### 後端

- PHP 8
- Laravel 10
- Laravel Fortify
- Laravel Jetstream
- Laravel Sanctum
- Inertia.js
- Yajra/OCI8 Oracle 資料庫支援
- SQL Server、Oracle PDO / DB Facade 資料庫整合

### 前端

- JavaScript
- Vue 3
- HTML / Blade
- CSS
- Axios
- Vite

### 資料庫與工具

- SQL Server
- Oracle Database
- SQLite、MySQL、PostgreSQL 設定支援
- Composer
- NPM
- PHPUnit

## 技術架構

專案採用 Laravel 的 MVC 架構：

- `routes/`：定義網頁與 API 路由
- `app/Http/Controllers/`：處理頁面與資料操作邏輯
- `app/Helper/`：共用導覽列及動態設定資料的輔助功能
- `app/Models/`：應用程式資料模型
- `resources/views/`：Blade 頁面與版面
- `resources/js/`：Vue 元件、共用工具及前端互動邏輯
- `resources/css/`：前端樣式
- `config/`：應用程式、資料庫及第三方套件設定
- `database/migrations/`：資料庫結構遷移檔
- `database/seeders/`：初始資料設定
- `tests/`：自動化測試

前端首頁與主要功能透過 Vite 載入 Vue 3 元件；後端主要使用 Laravel Blade 與 Controller 回傳頁面及 JSON 資料。

## 資料庫整合說明

專案預設資料庫連線為 SQL Server，並額外提供 Oracle 連線設定。部分功能會從 SQL Server 查詢贈獎紀錄，再產生 SQL 檔案，透過 Oracle SQL\*Plus 匯入指定資料庫。

此流程需要：

- 可連線的內部 SQL Server 資料庫
- 可連線的 Oracle 資料庫
- 已安裝對應的 PDO / OCI 擴充套件
- SQL\*Plus 或相容的 Oracle CLI
- 既定的資料表、欄位及商業規則
- 對應的 Shell Script 與伺服器權限

以上環境及資料皆屬實際運作需要，公開作品中不包含任何可直接使用的帳號、密碼或公司資料。

## 系統需求

實際執行環境需自行準備：

- PHP 8.1 或以上
- Composer 2
- Node.js 與 NPM
- Laravel 相依的 PHP 擬檔、資料庫及作業系統擴充套件
- SQL Server 或其他支援的資料庫
- Oracle Client / SQL\*Plus（僅使用 Oracle 匯入功能時需要）

## 專案目錄

```text
app/              Laravel 應用程式與商業邏輯
bootstrap/        框架啟動檔
config/           系統與資料庫設定
database/         Migration、Factory 與 Seeder
public/           公開入口及編譯後資源
resources/        Vue、CSS、Blade 頁面與前端資源
routes/           HTTP 與 API 路由
storage/          快取、日誌、上傳與暫存檔案
tests/            Feature 與 Unit 測試
vendor/           Composer 安裝套件
node_modules/     NPM 安裝套件
```

## 安全與隱私說明

- 本專案不包含正式環境的資料庫帳密。
- 資料表名稱、欄位名稱及 SQL 邏輯可能已簡化或保留為作品展示用途。
- 不應將正式環境設定、個資、帳號或金鑰提交至公開儲存庫。
- 部署前應另外設定環境變數、資料庫權限及檔案存取權限。

## 測試

專案包含 Laravel 測試目錄與 PHPUnit 設定。完整測試需先補齊資料庫、環境變數及測試資料。

```bash
php artisan test
```

## 授權

本專案僅供個人作品展示與技術交流使用。未經授權，不得將其直接部署於正式營運環境。
