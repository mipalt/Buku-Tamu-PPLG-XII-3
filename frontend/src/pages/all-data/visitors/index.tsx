import React from "react";
import VisitorsTable from "./VisitorsTable";

const VisitorsPage: React.FC = () => {
  return (
    <div className="visitors-page">
      <h1>Data Kunjungan</h1>
      <VisitorsTable />
    </div>
  );
};

export default VisitorsPage;
